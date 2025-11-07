<?php

use App\Livewire\LoginPage;
use App\Livewire\Register;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordResetController;

Route::get('/register', Register::class)->name('register');
Route::get('/login',LoginPage::class)->name('login');

Route::prefix('password')->group(function () {

    Route::get('/forgot', [PasswordResetController::class, 'showForgotPasswordForm'])
     ->name('password.form')
     ->middleware('guest');

    Route::post('/forgot', [PasswordResetController::class, 'sendResetLinkEmail'])
    ->middleware('guest')
    ->name('password.request');

    Route::get('/reset/{token}', [PasswordResetController::class, 'showResetForm'])
    ->middleware('guest')
    ->name('password.reset');

    Route::post('/reset', [PasswordResetController::class, 'reset'])
    ->middleware('guest')
    ->name('password.update');
});
