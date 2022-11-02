<?php


namespace Tests\Feature\App\Http\Controllers;


use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Event;
use Tests\RequestFactories\SignUpFormRequestFactory;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function it_store_success():void
    {
        Notification::fake();
        Event::fake();

        $request = SignUpFormRequestFactory::factory()->create([
            'email'=>'andrenik@gmail.com',
            'password'=>'1234567890',
            'password_confirmation' => '1234567890'
        ]);

        $this->assertDatabaseMissing('users',[
           'email'=>$request['email']
        ]);

        $response = $this->post(
            action([AuthController::class,'store']),
            $request
        );

        $this->assertDatabaseHas('users',[
            'email'=>$request['email']
        ]);

        $response
            ->assertValid()
            ->assertRedirect(route('home'));


    }

}
