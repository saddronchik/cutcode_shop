<?php

use Illuminate\Support\Facades\Route;

Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});
Route::get('/', function () {
    // logger()
    //     ->channel('telegram')
    //     ->info('123');
    return view('welcome');
});
