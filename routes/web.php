<?php

use Illuminate\Support\Facades\Route;

Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});

Route::get('/', function () {
    return view('welcome')->name('home');
});
