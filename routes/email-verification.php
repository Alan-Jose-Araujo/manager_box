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
         * Controller: EmailVerificationController
         * Controller Method: showVerifyEmailNotice
         * Name: email_verification.notice
         */
        Route::get('/verify', [EmailVerificationController::class, 'showVerifyEmailNotice'])
            ->middleware('auth')
            ->name('email_verification.notice');

        /**
         * Url: email-verification/verify
         * HTTP Method: GET
         * Controller: EmailVerificationController
         * Controller Method: showVerifyEmailNotice
         * Name: email_verification.verify
         */
        Route::get('/verify/{id}/{hash}', [EmailVerificationController::class, 'showVerifyEmailNotice'])
            ->middleware(['auth', 'signed'])
            ->name('email_verification.verify');

        /**
         * Url: email-verification/send-notification
         * HTTP Method: POST
         * Controller: EmailVerificationController
         * Controller Method: sendEmailVerificationNotification
         * Name: email_verification.send_verification
         */
        Route::post('/send-notification', [EmailVerificationController::class, 'sendEmailVerificationNotification'])
            ->middleware(['auth', 'throttle:6,1'])
            ->name('email_verification.send_verification');
    });