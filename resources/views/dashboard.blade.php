@extends('cloud-sass::layouts.app')

@section('title', 'Create Client')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('Cloud SASS Dashbaord') }}
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
                            <h3>{{ __('Welcome to Cloud SASS Dashbaord') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
