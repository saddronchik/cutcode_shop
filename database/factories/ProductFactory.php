<?php

namespace Database\Factories;

use Domain\Catalog\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    public function definition()
    {
        return [
            'title'=>ucfirst($this->faker->words(2,true)),
            'brand_id'=>Brand::query()->inRandomOrder()->value('id'),
            'thumbnail'=> $this->faker->fixturesImage('products','products'),
//            'thumbnail'=> $this->faker->file(
//                base_path('tests\Fixtures\images\products'),
//                storage_path('/app/public/images/products'),
//
//            ),
            'price'=>$this->faker->numberBetween(10000,1000000),
            'on_home_page'=>$this->faker->boolean(),
            'sorting'=>$this->faker->numberBetween(1,999),
            'text'=>$this->faker->realText(),
        ];
    }
}
