<?php

/**
 * Here are the routes related to the registered client:
 * -- Company
 * -- User
 * -- Address
 */

use App\Http\Controllers\RegisteredClientController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\RoleMiddleware;

Route::prefix('client')
    ->group(function () {

        /**
         * Url: client/register
         * HTTP Method: GET
         * Controller: RegisteredClientController
         * Controller Method: store
         * Name: client.register
         */
        Route::get('register', [RegisteredClientController::class, 'store'])
            ->middleware('guest')
            ->name('client.register');

        /**
         * Url: client/update-company
         * HTTP Method: PATCH
         * Controller: RegisteredClientController
         * Controller Method: updateCompany
         * Name: client.update_company
         */
        Route::patch('/update-company', [RegisteredClientController::class, 'updateCompany'])
            ->middleware([
                'custom.auth',
                RoleMiddleware::using('company_admin'),
            ])
            ->name('client.update_company');

        /**
         * Url: client/disable-account
         * HTTP Method: PATCH
         * Controller: RegisteredClientController
         * Controller Method: disable
         * Name: client.disable_account
         */
        Route::patch('/disable-account', [RegisteredClientController::class, 'disable'])
            ->middleware([
                'custom.auth',
                RoleMiddleware::using('company_admin'),
            ])
            ->name('client.disable_account');

    });