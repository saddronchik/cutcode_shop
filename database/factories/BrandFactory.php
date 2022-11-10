<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{

    public function definition(): array
    {
        return [
            'title'=>$this->faker->company(),
            'thumbnail'=>$this->faker->fixturesImage('brands','public/images/brands'),
            'on_home_page'=>$this->faker->boolean(),
            'sorting'=>$this->faker->numberBetween(1,999),

        ];
    }
}
