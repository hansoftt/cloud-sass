<?php
namespace Hansoft\CloudSass\Http\Controllers;

use Hansoft\CloudSass\Models\Client;
use Hansoft\CloudSass\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClientsController extends Controller
{
    public function index()
    {
        $clients = Client::all(); // Fetch all clients from the database
        return view('cloud-sass::clients.index', ['clients' => $clients]);
    }

    public function create()
    {
        // Fetch all subscriptions from the database
        $subscriptions = Subscription::all();
        return view('cloud-sass::clients.create', ['subscriptions' => $subscriptions]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255|unique:cloud_sass_clients_table,name',
            'email'           => 'required|email|max:255|unique:cloud_sass_clients_table,email',
            'phone'           => 'required|string|max:255',
            'subdomain'       => 'required|string|max:255',
            'subscription_id' => 'required|exists:cloud_sass_subscriptions_table,id',
        ]);

        $client = Client::query()->create($validated);

        // Set max execution time and memory limit
        $this->setMysqlMaxExecutionLimit();

        // Create the database for the client
        $this->createDatabase($client);

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

        // You can also pass any additional data to the view if needed
        // For example, you can pass a list of clients or other related data
        return view('cloud-sass::clients.edit', ['client' => $client, 'subscriptions' => $subscriptions]);
    }

    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255|unique:cloud_sass_clients_table,name,' . $id,
            'email'           => 'required|email|max:255|unique:cloud_sass_clients_table,email,' . $id,
            'phone'           => 'required|string|max:255',
            'subdomain'       => 'required|string|max:255',
            'subscription_id' => 'required|exists:cloud_sass_subscriptions_table,id',
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

    protected function reconnectMySQL($databaseName)
    {
        Config::set('database.connections.mysql.username', config('cloud-sass.mysql_root_user'));
        Config::set('database.connections.mysql.password', config('cloud-sass.mysql_root_password'));
        Config::set('database.connections.mysql.database', $databaseName);
        DB::purge('mysql');
        DB::connection('mysql')->reconnect();
        DB::setDefaultConnection('mysql');
    }

    protected function createDatabase($client)
    {
        $this->reconnectMySQL(null);

        $databaseName = $client->database_name;

        // Logic to create a database for the client
        // This is just a placeholder. You should implement the actual logic to create a database.
        // Assuming you have a method to get the database name
        // Use your database creation logic here
        // For example, using Laravel's DB facade or any other method you prefer

        DB::statement("CREATE DATABASE IF NOT EXISTS `$databaseName`");

        $this->reconnectMySQL($databaseName);

        Artisan::call('migrate', [
            '--database' => 'mysql',
            '--path'     => config('cloud-sass.migrations_location'),
            '--force'    => true,
        ]);

        if (config('cloud-sass.database_seeder')) {
            Artisan::call(config('cloud-sass.database_seeder'),
                [
                    $client->name, $client->email, $client->phone, 'admin',
                    '--force'    => true,
                ]
            );
        }
    }

    protected function setMysqlMaxExecutionLimit()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        set_time_limit(0);
    }
}
