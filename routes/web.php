<?php

use App\Http\Controllers\RegisteredClientController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(RegisteredClientController::class)->group(function() {
    Route::middleware('guest')->group(function() {
        Route::post('/register', 'store')->name('client.register');
    });
});