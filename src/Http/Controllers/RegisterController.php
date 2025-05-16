<?php
namespace Hansoft\CloudSass\Http\Controllers;

use Exception;
use Hansoft\CloudSass\Mail\ClientRegisteredToAdmin;
use Hansoft\CloudSass\Mail\ClientRegisteredToClient;
use Hansoft\CloudSass\Models\Client;
use Hansoft\CloudSass\Models\Subscription;
use Hansoft\CloudSass\Traits\HasClientFunctions;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    use HasClientFunctions;

    public function register(Request $request)
    {
        try {

            // Validate the request data
            $validated = $request->validate([
                'name'  => 'required|string|max:255',
                'short_name'  => 'required|string|max:255|unique:cloud_sass_clients_table,short_name',
                'email' => 'required|email|max:255|unique:cloud_sass_clients_table,email',
                'phone' => 'required|string|max:255',
            ]);

            $validated['subdomain'] = Str::slug($validated['name'], '-'); // Generate subdomain from name
            $validated['subscription_id'] = Subscription::query()->where('name', 'like', '%Trial%')->first()->id; // Set default subscription ID
            $validated['is_active']       = true;

            // Create a new client record in the database
            $client = Client::query()->create($validated);

            // Set max execution time and memory limit
            $this->setMysqlMaxExecutionLimit();

            // Create the database for the client
            $this->createDatabase($client);

            Mail::to($client->email)->send(new ClientRegisteredToClient($client));

            if (config('cloud-sass.admin_email')) {
                Mail::to(config('cloud-sass.admin_email'))->send(new ClientRegisteredToAdmin($client));
            }

            return response()->json([
                'error'   => false,
                'message' => 'Trial registered successfully',
                'data'    => null,
                'code'    => 200,
            ]);
        } catch (ValidationException $e) {
            $message = 'Validation error occurred: ' . $e->getMessage();
            return response()->json([
                'error'   => true,
                'message' => $message,
                'data'    => null,
                'code'    => 102,
                'details' => collect($e->errors())->values()->join(', '),
            ]);
        } catch (Exception $e) {
            $message = 'An error occurred: ' . $e->getMessage();
            return response()->json([
                'error'   => true,
                'message' => $message,
                'data'    => null,
                'code'    => 103,
                'details' => (! empty($e) && is_object($e)) ? $e->getMessage() . ' --> ' . $e->getFile() . ' At Line : ' . $e->getLine() : '',
            ]);
        }
    }
}
