<?php

namespace App\Providers;

use App\Contracts\RouteRegistrar;
use App\Routing\AppRegistrar;

use App\Routing\AuthRegistrar;
use App\Routing\CartRegistrar;
use App\Routing\CatalogRegistrar;
use App\Routing\OrderRegistrar;
use App\Routing\ProductRegistrar;
use RuntimeException;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';

//Отвечают за роуты перенапрвляют все вместо файла web
    protected array $registrars = [
        AppRegistrar::class,
        AuthRegistrar::class,
        OrderRegistrar::class,
        ProductRegistrar::class,
        CatalogRegistrar::class,
        CartRegistrar::class,
        OrderRegistrar::class,
    ];

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function (Registrar $router){
           $this->mapRoutes($router, $this->registrars);
        });

//        $this->routes(function () {
//            Route::middleware('api')
//                ->prefix('api')
//                ->group(base_path('routes/api.php'));
//
//            Route::middleware('web')
//                ->group(base_path('routes/web.php'));
//        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('global', function (Request $request) {
        return Limit::perMinute(500)
            ->by($request->user()?->id ?: $request->ip())
            ->response(function(Request $request, array $headers ){
                return response('Take it easy', Response::HTTP_TOO_MANY_REQUESTS, $headers);
            });
        });

        RateLimiter::for('auth', function (Request $request) {
            return Limit::perMinute(20)->by($request->id());
        });

        RateLimiter::for('api', function (Request $request) {

            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

    protected function  mapRoutes(Registrar $router, array $registrars):void
    {
        foreach ($registrars as $registrar){
            if (! class_exists($registrar) || ! is_subclass_of($registrar,RouteRegistrar::class)){
                throw new RuntimeException(sprintf(
                   'Cannot map routes \'%s\', it is not a valid routes class',
                ));
            }
            (new $registrar)->map($router);
        }
    }
}
