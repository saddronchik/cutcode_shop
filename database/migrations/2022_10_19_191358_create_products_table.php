<?php

use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();

            $table->string('thumbnail')->nullable();

            $table->unsignedInteger('price')->default(0);
            $table->timestamps();

            $table->foreignIdFor(Brand::class)
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });

        Schema::create('category_product',function(Blueprint $table){
            $table->id();

            $table->foreignIdFor(Category::class)
            ->constrained()
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->foreignIdFor(Product::class)
            ->constrained()
            ->cascadeOnUpdate()
            ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (app()->isLocal()) {
            Schema::dropIfExists('category_product');
        Schema::dropIfExists('products');
        }
    }
};
