<?php

use App\Livewire\Welcome;
use App\Livewire\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Mail\VerifyEmail;

Route::get('/', Welcome::class);

Route::get('/dashboard', Dashboard::class)->name('dashboard');

Route::get('/estoque/novo', function () {
    return view('add-new-stock');
})->name('stock.create');

// Preview route for email verification
Route::get('/email/preview', function () {
    $userName = 'Teste Visual';

    $verificationUrl = url('/email/verify/1/fake_hash_123');

    return new VerifyEmail($userName, $verificationUrl);
});
