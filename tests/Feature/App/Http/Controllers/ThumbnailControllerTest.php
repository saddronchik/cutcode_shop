<?php


namespace App\Http\Controllers;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ThumbnailControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */

    public function it_success_response():void
    {
        //TODO: Доделать тесты изображений
    $storage = Storage::fake('images');

    }
}
