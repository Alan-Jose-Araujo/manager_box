<?php

use App\Http\Controllers\RegisteredClientController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Client.

Route::controller(RegisteredClientController::class)->group(function() {
    Route::middleware('guest')->group(function() {
        Route::post('/register', 'store')->name('client.register');
    });

    Route::middleware('auth')->group(function() {
        Route::patch('/update-company', 'updateCompany');
        Route::patch('/disable-account', 'disable');
    });
})->prefix('client');