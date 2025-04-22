@extends('cloud-sass::layouts.app')

@section('title', 'Edit Client')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('Edit Client') }}
                    </div>

                    <div class="card-body">
                        <div>
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('cloud-sass.clients.update', ['id' => $client->id]) }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="name" class="form-label">Client Name</label>
                                        <input type="text" class="form-control" value="{{ old('name', $client->name) }}"
                                            id="name" name="name" required>
                                        @error('name')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" value="{{ old('email', $client->email) }}"
                                            id="email" name="email" required>
                                        @error('email')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control" value="{{ old('phone', $client->phone) }}"
                                            id="phone" name="phone" required>
                                        @error('phone')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="subdomain" class="form-label">Subdomain</label>
                                        <input type="text" class="form-control" id="subdomain"
                                            value="{{ old('subdomain', $client->subdomain) }}" name="subdomain" required>
                                        @error('subdomain')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2 align-content-end">
                                        <button type="submit" class="btn btn-primary mt-4">Update Client</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
