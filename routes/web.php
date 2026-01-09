<?php

/**
 * Here are the routes related to application web context.
 */

use App\Http\Middleware\RedirectToDashboardIfAlreadyAuthenticated;
use App\Livewire\Dashboard;
use App\Livewire\NotFound;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('client.show_register_form');
})->middleware([
    RedirectToDashboardIfAlreadyAuthenticated::class,
]);

// Provisory dashboard route.
Route::get('/dashboard', Dashboard::class)
->middleware(['custom.auth', 'verified'])
->name('dashboard');

Route::fallback(NotFound::class);
