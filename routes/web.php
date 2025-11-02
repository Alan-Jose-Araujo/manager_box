<?php

/**
 * Here are the routes related to application web context.
 */

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('client.show_register_form');
});
