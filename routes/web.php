<?php

use Hansoft\CloudSass\Http\Controllers\ClientsController;
use Hansoft\CloudSass\Http\Controllers\ProjectsController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'auth'], 'prefix' => '/cloud-sass', 'as' => 'cloud-sass.'], function () {
    // Projects
    // Note: The prefix and route names for projects are the same as clients for consistency.
    // You can change them if needed.
    // For example, you can change 'projects' to 'tasks' or any other name.
    // This is just a suggestion for better organization.
    // If you want to keep them separate, you can change the prefix and route names accordingly.
    // For example, you can change 'projects' to 'sass' or any other name.
    // This is just a suggestion for better organization.
    // You can also add a middleware for authentication or authorization if needed.
    // For example, you can use 'auth' middleware to protect the routes.
    // You can also use 'auth:api' middleware if you are using API authentication.
    // You can also use 'auth:sanctum' middleware if you are using Sanctum authentication.
    // You can also use 'auth:jwt' middleware if you are using JWT authentication.
    // You can also use 'auth:passport' middleware if you are using Passport authentication.
    // You can also use 'auth:session' middleware if you are using session authentication.
    // You can also use 'auth:basic' middleware if you are using basic authentication.
    // You can also use 'auth:token' middleware if you are using token authentication.
    Route::group(['prefix' => '/projects', 'as' => 'projects.'], function () {
        Route::get('/', [ProjectsController::class, 'index'])->name('index');
        Route::get('/create', [ProjectsController::class, 'create'])->name('create');
        Route::post('/store', [ProjectsController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ProjectsController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [ProjectsController::class, 'update'])->name('update');
        Route::post('/destroy', [ProjectsController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => '/clients', 'as' => 'clients.'], function () {
        Route::get('/', [ClientsController::class, 'index'])->name('index');
        Route::get('/create', [ClientsController::class, 'create'])->name('create');
        Route::post('/store', [ClientsController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ClientsController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [ClientsController::class, 'update'])->name('update');
        Route::post('/destroy', [ClientsController::class, 'destroy'])->name('destroy');
    });
});
