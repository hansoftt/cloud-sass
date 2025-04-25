<?php
namespace Hansoft\CloudSass\Http\Controllers;

use Exception;
use Hansoft\CloudSass\Models\Client;
use Hansoft\CloudSass\Models\Subscription;
use Hansoft\CloudSass\Traits\HasClientFunctions;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    use HasClientFunctions;

    public function register(Request $request)
    {
        try {
            // Validate the request data
            $validated = $request->validate([
                'name'  => 'required|string|max:255|unique:cloud_sass_clients_table,name',
                'email' => 'required|email|max:255|unique:cloud_sass_clients_table,email',
                'phone' => 'required|string|max:255',
            ]);

            $validated['subscription_id'] = Subscription::query()->where('name', 'like', '%Trial%')->first()->id; // Set default subscription ID
            $validated['is_active']       = true;

            // Create a new client record in the database
            $client = Client::query()->create($validated);

            // Set max execution time and memory limit
            $this->setMysqlMaxExecutionLimit();

            // Create the database for the client
            $this->createDatabase($client);

            return back()->with('success', 'Client created successfully.');
        } catch (ValidationException $e) {
            return back()->with('error', 'Validation failed: ' . collect($e->errors())->values()->join(','));
        } catch (Exception $e) {
            return back()->with('error', 'An error occurred while creating the client: ' . $e->getMessage());
        }
    }
}
