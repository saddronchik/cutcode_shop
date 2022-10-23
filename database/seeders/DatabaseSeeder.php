<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
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
        Brand::factory(20)->create();

        Category::factory(10)
            ->has(Product::factory(rand(5,15)));

        // Product::factory(20)
        //     ->has(Category::factory(rand(1,3)))
        //     ->create();

    }
}
