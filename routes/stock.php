<?php

/**
 * Here are the routes related to the stock.
 */

use App\Livewire\Stock\StockListing;
use Illuminate\Support\Facades\Route;

Route::prefix('stock')
    ->group(function () {

        /**
         * Url: stock/list
         * HTTP Method: GET
         * Middlewares: custom.auth, signed
         * Component: StockListing
         * Name: stock.list
         */
        Route::get('/list', StockListing::class)
            ->name('stock.list');

    })->middleware(['custom.auth', 'signed']);
