@extends('cloud-sass::layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('Cloud SASS Dashboard') }}
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
                            <p>{{ __('Welcome to Cloud SASS Dashboard') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
