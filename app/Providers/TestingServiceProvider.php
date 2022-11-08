<?php

namespace App\Providers;


use Faker\Factory;
use Generator;
use Illuminate\Support\ServiceProvider;
use Support\Testing\FakerImageProvider;

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
