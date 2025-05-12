@extends('cloud-sass::layouts.app')

@section('title', 'Edit Subscription')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('Edit Subscription') }}
                    </div>

                    <div class="card-body">
                        <div>
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('cloud-sass.subscriptions.update', ['id' => $subscription->id]) }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="name" class="form-label">Subscription Name</label>
                                        <input type="text" class="form-control" value="{{ old('name', $subscription->name) }}"
                                            id="name" name="name" required>
                                        @error('name')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="validity" class="form-label">Validity (Days)</label>
                                        <input type="number" class="form-control" value="{{ old('validity', $subscription->validity) }}"
                                            id="validity" name="validity" required>
                                        @error('validity')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="no_of_users" class="form-label">Users (# of Users)</label>
                                        <input type="number" class="form-control" value="{{ old('no_of_users', $subscription->no_of_users) }}"
                                            id="no_of_users" name="no_of_users" required>
                                        @error('no_of_users')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2 align-content-end">
                                        <button type="submit" class="btn btn-primary mt-4">Update Subscription</button>
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
