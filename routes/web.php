<?php

use App\Livewire\Welcome;
use App\Livewire\Dashboard; // <-- IMPORTANTE: Importe a classe do componente
use Illuminate\Support\Facades\Route;


Route::get('/', Welcome::class);

// USE ESTA OPÇÃO: Rota aponta diretamente para a classe do componente Livewire
Route::get('/dashboard', Dashboard::class);
