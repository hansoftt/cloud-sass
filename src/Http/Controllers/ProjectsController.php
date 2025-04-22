<?php

namespace Hansoft\CloudSass\Http\Controllers;

use Hansoft\CloudSass\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = Project::all(); // Fetch all projects from the database
        return view('cloud-sass::projects.index', ['projects' => $projects]);
    }

    public function create()
    {
        return view('cloud-sass::projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:cloud_sass_projects_table,name',
            'migrations_location' => 'required|string|max:255',
        ]);

        Project::query()->create($validated);

        return redirect()->route('cloud-sass.projects.index')->with('success', 'Project created successfully.');
    }

    public function edit($id)
    {
        $project = Project::findOrFail($id); // Fetch the project by ID
        if (!$project) {
            return redirect()->route('cloud-sass.projects.index')->with('error', 'Project not found.');
        }

        // You can also pass any additional data to the view if needed
        // For example, you can pass a list of clients or other related data
        return view('cloud-sass::projects.edit', ['project' => $project]);
    }

    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:cloud_sass_projects_table,name,' . $id,
            'migrations_location' => 'required|string|max:255',
        ]);

        $project = Project::findOrFail($id); // Fetch the project by ID
        if (!$project) {
            return redirect()->route('cloud-sass.projects.index')->with('error', 'Project not found.');
        }

        $project->update($validated); // Update the project with the validated data

        return redirect()->route('cloud-sass.projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $project = Project::findOrFail($id); // Fetch the project by ID
        if (!$project) {
            return redirect()->route('cloud-sass.projects.index')->with('error', 'Project not found.');
        }

        $project->delete(); // Delete the project

        return redirect()->route('cloud-sass.projects.index')->with('success', 'Project deleted successfully.');
    }
}
