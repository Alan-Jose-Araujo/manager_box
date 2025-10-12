<?php

/**
 * Here are the routes related to the email verification.
 */

use App\Http\Controllers\EmailVerificationController;
use Illuminate\Support\Facades\Route;

Route::prefix('email-verification')
    ->group(function () {

        /**
         * Url: email-verification/verify
         * HTTP Method: GET
         * Middleware: auth
         * Controller: EmailVerificationController
         * Controller Method: showVerifyEmailNotice
         * Name: email_verification.notice
         */
        Route::get('/verify', [EmailVerificationController::class, 'showVerifyEmailNotice'])
            ->middleware('custom.auth')
            ->name('verification.notice');

        /**
         * Url: email-verification/verify
         * HTTP Method: GET
         * Middlewares: auth, signed
         * Controller: EmailVerificationController
         * Controller Method: showVerifyEmailNotice
         * Name: email_verification.verify
         */
        Route::get('/verify/{id}/{hash}', [EmailVerificationController::class, 'verifyEmail'])
            ->middleware(['custom.auth', 'signed'])
            ->name('verification.verify');

        /**
         * Url: email-verification/send-notification
         * HTTP Method: POST
         * Middlewares: auth, throttle
         * Controller: EmailVerificationController
         * Controller Method: sendEmailVerificationNotification
         * Name: email_verification.send_verification
         */
        Route::post('/send-notification', [EmailVerificationController::class, 'sendEmailVerificationNotification'])
            ->middleware(['custom.auth', 'throttle:6,1'])
            ->name('verification.send');
    });