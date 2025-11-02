<?php

/**
 * Here are the routes related to application web context.
 */

use Illuminate\Support\Facades\Route;
use App\Livewire\Register;

Route::get('/register', Register::class)->name('register');
