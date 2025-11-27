<?php

/**
 * Here are the routes related to application web context.
 */

use App\Livewire\Dashboard;
use App\Livewire\NotFound;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('client.show_register_form');
});


// Provisory dashboard route.
// Route::get('/dashboard', function() {
//     return 'Olá';
// })->middleware(['custom.auth', 'verified'])->name('dashboard');


Route::get('/dashboard', Dashboard::class)->name('dashboard');

Route::fallback(NotFound::class);
