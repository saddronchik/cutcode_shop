<?php


use Illuminate\Support\Facades\Route;

Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});






