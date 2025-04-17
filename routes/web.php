<?php

use Hansoft\CloudSass\Http\Controllers\ClientsController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/clients', [ClientsController::class, 'index'])->name('cloud-sass.index');
});
