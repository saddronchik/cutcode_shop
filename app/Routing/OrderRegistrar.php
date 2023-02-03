<?php


namespace App\Routing;


use App\Contracts\RouteRegistrar;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\CatalogViewMiddleware;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

class OrderRegistrar implements RouteRegistrar
{

    public function map(Registrar $registrar): void
    {
       Route::middleware('web')->group(function (){
            Route::get('/order',[OrderController::class,'index'])->name('order');
            Route::post('/order',[OrderController::class,'handle'])->name('order.handle');

       });
    }
}
