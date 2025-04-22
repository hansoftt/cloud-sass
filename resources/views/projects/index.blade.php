@extends('cloud-sass::layouts.app')

@section('title', 'Projects')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('Projects') }}
                        <div class="float-end">
                            <a href="{{ route('cloud-sass.projects.create') }}" class="btn btn-primary">
                                {{ __('Create Project') }}
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
                                            <th>Project Name</th>
                                            <th>Migrations Location</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    @forelse($projects as $project)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $project->name }}</td>
                                            <td>{{ $project->migrations_location ?: 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('cloud-sass.projects.edit', ['id' => $project->id]) }}" class="btn btn-info">
                                                    {{ __('Edit') }}
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">No projects found.</td>
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
@endsection
