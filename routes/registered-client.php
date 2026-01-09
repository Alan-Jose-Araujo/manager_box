<?php

/**
 * Here are the routes related to the registered client:
 * -- Company
 * -- User
 * -- Address
 */

use App\Http\Controllers\RegisteredClientController;
use App\Http\Middleware\RedirectToDashboardIfAlreadyAuthenticated;
use App\Livewire\Register;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\RoleMiddleware;

Route::prefix('client')
    ->group(function () {

        /**
         * Url: client/register
         * HTTP Method: GET
         * Component: Register
         * Name: client.show_register_form
         */
        Route::get('/register', Register::class)
        ->middleware([
            RedirectToDashboardIfAlreadyAuthenticated::class,
        ])->name('client.show_register_form');

        /**
         * Url: client/register
         * HTTP Method: POST
         * Controller: RegisteredClientController
         * Controller Method: store
         * Name: client.register
         */
        Route::post('/register', [RegisteredClientController::class, 'store'])
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
                'verified',
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
                'verified',
                RoleMiddleware::using('company_admin'),
            ])
            ->name('client.disable_account');

    });
