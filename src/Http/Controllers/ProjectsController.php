<?php

namespace Hansoft\CloudSass\Http\Controllers;

use Illuminate\Routing\Controller;

class ProjectsController extends Controller
{
    public function index()
    {
        return view('cloud-sass::projects.index');
    }

    public function show($id)
    {
        return view('cloud-sass::projects.show', ['projectId' => $id]);
    }

    public function store()
    {
        // Handle the project creation logic here
        // For example, you can validate the request and create a new project in the database

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    public function update($id)
    {
        // Handle the project update logic here
        // For example, you can validate the request and update the project in the database

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy($id)
    {
        // Handle the project deletion logic here
        // For example, you can delete the project from the database

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}
