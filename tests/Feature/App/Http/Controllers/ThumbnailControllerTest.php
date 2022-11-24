<?php


namespace App\Http\Controllers;


use Database\Factories\ProductFactory;
use Faker\Provider\File;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Tests\TestCase;

class ThumbnailControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */

    public function it_success_generated():void
    {
        //TODO: Доделать тесты изображений
//        $size = '500x500';
//        $method = 'resize';
//        $storage = Storage::fake('images');
//
//        config()->set('thumbnail',['allowed_sizes'=>[$size]]);
//
//        $product = ProductFactory::new()->create();
//
//        $response = $this->get($product->makeThumbnail($size,$method));
//
//        $response->assertOk();
//        $storage->assertExists(
//            "products/$method/$size" . File::basename($product->thumbnail)
//        );

    }
}
