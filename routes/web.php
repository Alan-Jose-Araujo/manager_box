<?php

use App\Livewire\LoginPage;
use Illuminate\Support\Facades\Route;
use App\Livewire\Register;
use App\Livewire\NotFound;

Route::get('/register', Register::class)->name('register');
Route::get('/login',LoginPage::class)->name('login');
Route::fallback(NotFound::class);