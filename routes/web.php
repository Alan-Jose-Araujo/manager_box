<?php

use App\Livewire\LoginPage;
use Illuminate\Support\Facades\Route;
use App\Livewire\Register;

Route::get('/register', Register::class)->name('register');
Route::get('/login',LoginPage::class)->name('login');
