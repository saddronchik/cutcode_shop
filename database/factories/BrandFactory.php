<?php

namespace Database\Factories;

use Domain\Catalog\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
// * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domain\Catalog\Models\Brand>
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{

    protected $model = Brand::class;

    public function definition(): array
    {
        return [
            'title'=>$this->faker->company(),
//            'thumbnail'=>$this->faker->fixturesImage('brands','public/images/brands'),
            'thumbnail'=>$this->faker->fixturesImage('brands','brands'),
            'on_home_page'=>$this->faker->boolean(),
            'sorting'=>$this->faker->numberBetween(1,999),

        ];
    }
}
