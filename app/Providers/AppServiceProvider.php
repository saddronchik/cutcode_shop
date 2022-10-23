<?php

namespace App\Providers;

use App\Http\Kernel;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Connection;

use function Clue\StreamFilter\fun;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function boot()
    {
        Model::shouldBeStrict(!app()->isProduction());


        if(app()->isProduction() ){
            // DB::whenQueryingForLongerThan(CarbonInterval::seconds(5), function (Connection $connection) {
            //     logger()
            //         ->channel('telegram')
            //         ->debug('whenQueryingForLongerThan'. $connection->totalQueryDuration());
            // });

            DB::listen(function($query){
                if ($query->time>100) {
                    logger()
                        ->channel('telegram')
                        ->debug('query longer than 1ms'. $query->sql,$query->bindings);
                }
            });

                $kernel = app(Kernel::class);

                $kernel->whenRequestLifecycleIsLongerThan(
                    CarbonInterval::seconds(4),
                    function(){
                        logger()
                            ->channel('telegram')
                            ->debug('whenRequestLifecycleIsLongerThan:'. request()->url());
                    }
                );
        }


    }
}
