<?php

use App\Livewire\Welcome;
use App\Livewire\Dashboard;
use Illuminate\Support\Facades\Route;


Route::get('/', Welcome::class);


Route::get('/dashboard', App\Livewire\Dashboard::class);
