<?php
namespace Hansoft\CloudSass\Http\Controllers;

use Hansoft\CloudSass\Mail\ClientRegistered;
use Hansoft\CloudSass\Models\Client;
use Hansoft\CloudSass\Models\Subscription;
use Hansoft\CloudSass\Traits\HasClientFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ClientsController extends AdminBaseController
{
    use  HasClientFunctions;

    public function index()
    {
        $clients = Client::all(); // Fetch all clients from the database
        return view('cloud-sass::clients.index', ['clients' => $clients]);
    }

    public function create()
    {
        // Fetch all subscriptions from the database
        $subscriptions = Subscription::all();
        $active_statuses = [true, false]; // Define the active statuses
        return view('cloud-sass::clients.create', ['subscriptions' => $subscriptions, 'active_statuses' => $active_statuses]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255|unique:cloud_sass_clients_table,name',
            'email'           => 'required|email|max:255|unique:cloud_sass_clients_table,email',
            'phone'           => 'required|string|max:255',
            'subdomain'       => 'required|string|max:255',
            'subscription_id' => 'required|exists:cloud_sass_subscriptions_table,id',
            'is_active'       => 'nullable',
        ]);

        $client = Client::query()->create($validated);

        // Set max execution time and memory limit
        $this->setMysqlMaxExecutionLimit();

        // Create the database for the client
        $this->createDatabase($client);

        Mail::to($client->email)->send(new ClientRegistered($client));

        return redirect()->route('cloud-sass.clients.index')->with('success', 'Client created successfully.');
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id); // Fetch the client by ID
        if (! $client) {
            return redirect()->route('cloud-sass.clients.index')->with('error', 'Client not found.');
        }

        // Fetch all subscriptions from the database
        $subscriptions = Subscription::all();
        $active_statuses = [true, false]; // Define the active statuses

        // You can also pass any additional data to the view if needed
        // For example, you can pass a list of clients or other related data
        return view('cloud-sass::clients.edit', ['client' => $client, 'subscriptions' => $subscriptions, 'active_statuses' => $active_statuses]);
    }

    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255|unique:cloud_sass_clients_table,name,' . $id,
            'email'           => 'required|email|max:255|unique:cloud_sass_clients_table,email,' . $id,
            'phone'           => 'required|string|max:255',
            'subdomain'       => 'required|string|max:255',
            'subscription_id' => 'required|exists:cloud_sass_subscriptions_table,id',
            'is_active'       => 'nullable',
        ]);

        $client = Client::findOrFail($id); // Fetch the client by ID
        if (! $client) {
            return redirect()->route('cloud-sass.clients.index')->with('error', 'Client not found.');
        }

        $client->update($validated); // Update the client with the validated data

        return redirect()->route('cloud-sass.clients.index')->with('success', 'Client updated successfully.');
    }

    public function destroy(Request $request)
    {
        $id     = $request->id;
        $client = Client::findOrFail($id); // Fetch the client by ID
        if (! $client) {
            return redirect()->route('cloud-sass.clients.index')->with('error', 'Client not found.');
        }

        $databaseName = $client->database_name; // Get the database name

        $client->delete(); // Delete the client record from the database

        $this->reconnectMySQL(null);

        // Set max execution time and memory limit
        $this->setMysqlMaxExecutionLimit();

        // Logic to drop the database for the client
        DB::statement("DROP DATABASE IF EXISTS `" . $databaseName . "`");

        return redirect()->route('cloud-sass.clients.index')->with('success', 'Client deleted successfully.');
    }
}
