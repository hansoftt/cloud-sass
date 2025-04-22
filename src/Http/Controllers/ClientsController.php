<?php

namespace Hansoft\CloudSass\Http\Controllers;

use Hansoft\CloudSass\Models\Client;
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
        return view('cloud-sass::clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:cloud_sass_clients_table,name',
            'email' => 'required|email|max:255|unique:cloud_sass_clients_table,email',
            'phone' => 'required|string|max:255',
            'subdomain' => 'required|string|max:255',
        ]);

        $client = Client::query()->create($validated);

        // Create the database for the client
        $this->createDatabase($client);

        return redirect()->route('cloud-sass.clients.index')->with('success', 'Client created successfully.');
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id); // Fetch the client by ID
        if (!$client) {
            return redirect()->route('cloud-sass.clients.index')->with('error', 'Client not found.');
        }

        // You can also pass any additional data to the view if needed
        // For example, you can pass a list of clients or other related data
        return view('cloud-sass::clients.edit', ['client' => $client]);
    }

    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:cloud_sass_clients_table,name,' . $id,
            'email' => 'required|email|max:255|unique:cloud_sass_clients_table,email,' . $id,
            'phone' => 'required|string|max:255',
            'subdomain' => 'required|string|max:255',
        ]);

        $client = Client::findOrFail($id); // Fetch the client by ID
        if (!$client) {
            return redirect()->route('cloud-sass.clients.index')->with('error', 'Client not found.');
        }

        $client->update($validated); // Update the client with the validated data

        return redirect()->route('cloud-sass.clients.index')->with('success', 'Client updated successfully.');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $client = Client::findOrFail($id); // Fetch the client by ID
        if (!$client) {
            return redirect()->route('cloud-sass.clients.index')->with('error', 'Client not found.');
        }

        $this->reconnectMySQL(null);
        // Logic to drop the database for the client
        DB::statement("DROP DATABASE IF EXISTS `" . $client->database_name . "`");

        $this->reconnectSqlite();

        $client->delete(); // Delete the client

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

        // Logic to create a database for the client
        // This is just a placeholder. You should implement the actual logic to create a database.
        $databaseName = $client->database_name; // Assuming you have a method to get the database name
        // Use your database creation logic here
        // For example, using Laravel's DB facade or any other method you prefer
        DB::statement("CREATE DATABASE IF NOT EXISTS `$databaseName`");

        $this->reconnectMySQL($databaseName);

        Artisan::call('migrate', [
            '--database' => 'mysql',
            '--path' => config('cloud-sass.migrations_location'),
            '--force' => true,
        ]);

        DB::statement('INSERT INTO users (`name`, `email`, `email_verified_at`, `password`, `remember_token`) VALUES (?, ?, ?, ?, ?)', [
            $client->name,
            $client->email,
            now(),
            Hash::make($client->phone),
            null
        ]);
    }
}
