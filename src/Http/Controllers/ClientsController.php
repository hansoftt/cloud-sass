<?php

namespace Hansoft\CloudSass\Http\Controllers;

use Hansoft\CloudSass\Models\Client;
use Hansoft\CloudSass\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ClientsController extends Controller
{
    public function index()
    {
        $clients = Client::all(); // Fetch all clients from the database
        return view('cloud-sass::clients.index', ['clients' => $clients]);
    }

    public function create()
    {
        $projects = Project::all(); // Fetch all projects from the database
        return view('cloud-sass::clients.create', ['projects' => $projects]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:cloud_sass_clients_table,name',
            'email' => 'required|email|max:255|unique:cloud_sass_clients_table,email',
            'phone' => 'required|string|max:255',
            'subdomain' => 'required|string|max:255',
            'project_id' => 'required|exists:cloud_sass_projects_table,id',
        ]);

        Client::query()->create($validated);

        return redirect()->route('cloud-sass.clients.index')->with('success', 'Client created successfully.');
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id); // Fetch the client by ID
        if (!$client) {
            return redirect()->route('cloud-sass.clients.index')->with('error', 'Client not found.');
        }

        $projects = Project::all(); // Fetch all projects from the database

        // You can also pass any additional data to the view if needed
        // For example, you can pass a list of clients or other related data
        return view('cloud-sass::clients.edit', ['client' => $client, 'projects' => $projects]);
    }

    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:cloud_sass_clients_table,name,' . $id,
            'email' => 'required|email|max:255|unique:cloud_sass_clients_table,email,' . $id,
            'phone' => 'required|string|max:255',
            'subdomain' => 'required|string|max:255',
            'project_id' => 'required|exists:cloud_sass_projects_table,id',
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

        $client->delete(); // Delete the client

        return redirect()->route('cloud-sass.clients.index')->with('success', 'Client deleted successfully.');
    }
}
