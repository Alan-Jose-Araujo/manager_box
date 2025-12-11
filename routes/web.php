<?php

use App\Livewire\Welcome;
use App\Livewire\Dashboard;
use Illuminate\Support\Facades\Route;

Route::get('/', Welcome::class);

Route::get('/dashboard', Dashboard::class)->name('dashboard');

Route::get('/estoque/novo', function () {
    return view('add-new-stock');
})->name('stock.create');
