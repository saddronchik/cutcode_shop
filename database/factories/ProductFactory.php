<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{

    public function definition()
    {
        return [
            'title'=>ucfirst($this->faker->words(2,true)),
            'brand_id'=>Brand::query()->inRandomOrder()->value('id'),
            'thumbnail'=> $this->faker->fixturesImage('products','public/images/products'),
//            'thumbnail'=> $this->faker->file(
//                base_path('tests\Fixtures\images\products'),
//                storage_path('/app/public/images/products'),
//
//            ),
            'price'=>$this->faker->numberBetween(1000,100000),
            'on_home_page'=>$this->faker->boolean(),
            'sorting'=>$this->faker->numberBetween(1,999),
        ];
    }
}
