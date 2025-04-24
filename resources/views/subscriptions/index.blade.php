@extends('cloud-sass::layouts.app')

@section('title', 'Subscriptions')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('Subscriptions') }}
                        <div class="float-end">
                            <a href="{{ route('cloud-sass.subscriptions.create') }}" class="btn btn-primary">
                                {{ __('Create Subscription') }}
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div>
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Subscription Name</th>
                                            <th>Validity (Days)</th>
                                            <th># of Users</th>
                                            <th># of Current Clients</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    @forelse($subscriptions as $subscription)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $subscription->name }}</td>
                                            <td>{{ $subscription->validity }}</td>
                                            <td>{{ $subscription->no_of_users }}</td>
                                            <td>{{ $subscription->clients->count() }}</td>
                                            <td>
                                                <a href="{{ route('cloud-sass.subscriptions.edit', ['id' => $subscription->id]) }}"
                                                    class="btn btn-info">
                                                    {{ __('Edit') }}
                                                </a>
                                                <button type="button" class="btn btn-danger"
                                                    onclick="deleteSubscription({{ $subscription->id }})">
                                                    {{ __('Delete') }}
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">No subscriptions found.</td>
                                        </tr>
                                    @endforelse
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form method="POST" id="delete_subscription_form" action="{{ route('cloud-sass.subscriptions.destroy') }}">
        @csrf
        <input type="hidden" name="id" id="subscription_id">
    </form>
@endsection

@section('scripts')
    <script>
        function deleteSubscription(id) {
            if (confirm('Are you sure you want to delete this subscription?')) {
                // Set the subscription ID in the hidden form
                document.getElementById('subscription_id').value = id;
                // Submit the form
                document.getElementById('delete_subscription_form').submit();
            }
        }
    </script>
@endsection
