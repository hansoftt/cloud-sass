<?php
namespace Hansoft\CloudSass\Http\Controllers;

use Hansoft\CloudSass\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionsController extends AdminBaseController
{
    public function index()
    {
        $subscriptions = Subscription::all(); // Fetch all subscriptions from the database
        return view('cloud-sass::subscriptions.index', ['subscriptions' => $subscriptions]);
    }

    public function create()
    {
        return view('cloud-sass::subscriptions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:cloud_sass_subscriptions_table,name',
            'validity'    => 'required|integer|min:1',
            'no_of_users' => 'required|integer|min:1',
        ]);

        $subscription = Subscription::query()->create($validated);

        return redirect()->route('cloud-sass.subscriptions.index')->with('success', 'Subscription created successfully.');
    }

    public function edit($id)
    {
        $subscription = Subscription::findOrFail($id); // Fetch the subscription by ID
        if (! $subscription) {
            return redirect()->route('cloud-sass.subscriptions.index')->with('error', 'Subscription not found.');
        }

        // You can also pass any additional data to the view if needed
        // For example, you can pass a list of subscriptions or other related data
        return view('cloud-sass::subscriptions.edit', ['subscription' => $subscription]);
    }

    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:cloud_sass_subscriptions_table,name,' . $id,
            'validity'    => 'required|integer|min:1',
            'no_of_users' => 'required|integer|min:1',
        ]);

        $subscription = Subscription::findOrFail($id); // Fetch the subscription by ID
        if (! $subscription) {
            return redirect()->route('cloud-sass.subscriptions.index')->with('error', 'Subscription not found.');
        }

        $subscription->update($validated); // Update the subscription with the validated data

        return redirect()->route('cloud-sass.subscriptions.index')->with('success', 'Subscription updated successfully.');
    }

    public function destroy(Request $request)
    {
        $id           = $request->id;
        $subscription = Subscription::findOrFail($id); // Fetch the subscription by ID
        if (! $subscription) {
            return redirect()->route('cloud-sass.subscriptions.index')->with('error', 'Subscription not found.');
        }

        $subscription->delete(); // Delete the subscription record from the database

        return redirect()->route('cloud-sass.subscriptions.index')->with('success', 'Subscription deleted successfully.');
    }
}
