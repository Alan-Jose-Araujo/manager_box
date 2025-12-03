<?php

use App\Http\Middleware\EnsureUserIsAuthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            // Registered Client.
            Route::middleware('web')
                ->group(base_path('routes/registered-client.php'));

            // Email Verification.
            Route::middleware('web')
                ->group(base_path('routes/email-verification.php'));

            // Authentication.
            Route::middleware('web')
            ->group(base_path('routes/authentication.php'));

            // Stock.
            Route::middleware('web')
            ->group(base_path('routes/stock.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'custom.auth' => EnsureUserIsAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
