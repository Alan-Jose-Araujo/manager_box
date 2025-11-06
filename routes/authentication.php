<?php

/**
 * Here are the routes related to authentication.
 */

use App\Http\Controllers\AuthController;
use App\Livewire\LoginPage;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {

    /**
     * Url: auth/login
     * HTTP Method: GET
     * Component: LoinPage
     * Name: auth.show_login_form
     */
    Route::get('/login', LoginPage::class)->name('auth.show_login_form');

    /**
     * Url: auth/login
     * HTTP Method: POST
     * Middleware: guest
     * Controller: AuthController
     * Controller Method: login
     * Name: auth.login
     */
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('guest')
        ->name('auth.login');

    /**
     * Url: auth/logout
     * HTTP Method: POST
     * Middleware: auth
     * Controller: AuthController
     * Controller Method: logout
     * Name: auth.logout
     */
    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('custom.auth')
        ->name('auth.logout');

    Route::get('/test', function () {
        echo auth()->user()->name;
    })->middleware('custom.auth');
});
