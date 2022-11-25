<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;


use Database\Factories\OptionFactory;
use Database\Factories\OptionValueFactory;
use Database\Factories\PropertyFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        BrandFactory::new()->count(20)->create();

        $properties = PropertyFactory::new()->count(10)->create();

        OptionFactory::new()->count(2)->create();

        $optionValues = OptionValueFactory::new()->count(20)->create();

        CategoryFactory::new()->count(10)
            ->has(Product::factory(10)
                ->hasAttached($optionValues)
                ->hasAttached($properties,function (){
                    return ['value'=>ucfirst(fake()->word())];
                })
            )
            ->create();
//        ProductFactory::new()->count(20)
//             ->has(Category::factory(rand(1,3)))
//             ->create();

    }
}
