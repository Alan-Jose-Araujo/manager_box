<?php

/**
 * Here are the routes related to application web context.
 */

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/csrf-token', function() {
    return [[
        'csrf-token' => csrf_token(),
    ]];
});

Route::get('/dashboard', function() {
    return ['success' => true];
})->middleware('custom.auth')->name('dashboard');