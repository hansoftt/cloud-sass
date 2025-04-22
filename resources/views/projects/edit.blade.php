@extends('cloud-sass::layouts.app')

@section('title', 'Edit Project')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('Edit Project') }}
                    </div>

                    <div class="card-body">
                        <div>
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('cloud-sass.projects.update', ['id' => $project->id]) }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="name" class="form-label">Project Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $project->name }}" required>
                                        @error('name')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="migrations_location" class="form-label">Migrations Location</label>
                                        <input type="text" class="form-control" id="migrations_location"
                                            name="migrations_location" value="{{ $project->migrations_location }}" required>
                                        @error('migrations_location')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2 align-content-end">
                                        <button type="submit" class="btn btn-primary mt-4">Update Project</button>
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
