<?php

namespace App\Providers;

use App\Support\Testing\FakerImageProvider;
use Faker\Factory;
use Generator;
use Illuminate\Support\ServiceProvider;

class TestingServiceProvider extends ServiceProvider
{

    public function register():void
    {
       $this->app->singleton(Generator::class, function(){
        $faker = Factory::create();
        $faker->appProvider(new FakerImageProvider($faker));

        return $faker;
       });
    }


    public function boot():void
    {
        //
    }
}
