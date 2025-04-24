@extends('cloud-sass::layouts.app')

@section('title', 'Clients')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('Clients') }}
                        <div class="float-end">
                            <a href="{{ route('cloud-sass.clients.create') }}" class="btn btn-primary">
                                {{ __('Create Client') }}
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
                                            <th>Client Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Subdomain</th>
                                            <th>Subscription</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    @forelse($clients as $client)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $client->name }}</td>
                                            <td>{{ $client->email }}</td>
                                            <td>{{ $client->phone }}</td>
                                            <td>{{ $client->subdomain }}</td>
                                            <td>
                                                {{ $client->subscription->name }}
                                                /
                                                ({{ $client->subscription->validity }} days)
                                            </td>
                                            <td>
                                                <span class="badge rounded-pill {{ $client->is_active ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $client->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('cloud-sass.clients.edit', ['id' => $client->id]) }}"
                                                    class="btn btn-info">
                                                    {{ __('Edit') }}
                                                </a>
                                                <button type="button" class="btn btn-danger"
                                                    onclick="deleteClient({{ $client->id }})">
                                                    {{ __('Delete') }}
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">No clients found.</td>
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
    <form method="POST" id="delete_client_form" action="{{ route('cloud-sass.clients.destroy') }}">
        @csrf
        <input type="hidden" name="id" id="client_id">
    </form>
@endsection

@section('scripts')
    <script>
        function deleteClient(id) {
            if (confirm('Are you sure you want to delete this client?')) {
                // Set the client ID in the hidden form
                document.getElementById('client_id').value = id;
                // Submit the form
                document.getElementById('delete_client_form').submit();
            }
        }
    </script>
@endsection
