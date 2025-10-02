<?php

use App\Http\Controllers\RegisteredClientController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\RoleMiddleware;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/csrf-token', function() {
    return [[
        'csrf-token' => csrf_token(),
    ]];
});

// Client.

Route::controller(RegisteredClientController::class)->group(function() {
    Route::middleware('guest')->group(function() {
        Route::post('/register', 'store')->name('client.register');
    });

    Route::middleware('auth')->group(function() {
        Route::patch('/update-company', 'updateCompany')->middleware(RoleMiddleware::using('company_admin'));
        Route::patch('/disable-account', 'disable')->middleware(RoleMiddleware::using('company_admin'));
    });
})->prefix('client');