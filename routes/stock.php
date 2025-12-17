<?php

/**
 * Here are the routes related to the stock.
 */

use App\Livewire\CreateStockItem;
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

        /**
         * Url: stock/create-item
         * HTTP Method: GET
         * Middlewares: custom.auth, signed
         * Component: CreateStockItem
         * Name: stock.show_create_item_form
         */
        Route::get('/create-item', CreateStockItem::class)
        ->name('stock.show_create_item_form');

    })->middleware(['custom.auth', 'signed']);
