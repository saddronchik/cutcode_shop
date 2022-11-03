<?php


namespace Tests\Feature\App\Http\Controllers;


use App\Http\Controllers\AuthController;
use App\Http\Requests\SignUpFormRequest;
use App\Listeners\SendEmailNewUserListener;
use App\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Event;
use Tests\RequestFactories\SignUpFormRequestFactory;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     * @return void
     */

    public function it_login_page_success():void
    {
        $this->get(action([AuthController::class,'index']))
                ->assertOk()
                ->assertSee('Вход в аккаунт')
                ->assertViewIs('auth.index');
    }

    /**
     * @test
     * @return void
     */

    public function it_login_up_page_success():void
    {
        $this->get(action([AuthController::class,'signUp']))
            ->assertOk()
            ->assertSee('Регистрация')
            ->assertViewIs('auth.sign-up');

    }
    /**
     * @test
     * @return void
     */

    public function it_forgot_page_success():void
    {
        $this->get(action([AuthController::class,'forgot']))
            ->assertOk()
            ->assertSee('Забыли пароль')
            ->assertViewIs('auth.forgot-password');

    }

    /**
     * @test
     * @return void
     */

    public function it_sign_in_success():void
    {
        $password = '1234567890';

        $user = User::factory()->create([
            'email'=>'andrenik@gmail.com',
            'password'=>bcrypt($password),
        ]);


        $request = SignUpFormRequest::factory()->create([
            'email'=>$user->email,
            'password'=>$password
        ]);
        dd($request);

       $response = $this->post(action([AuthController::class, 'signIn']),$request);

       $response->assertValid()
           ->assertRedirect(route('home'));

       $this->assertAuthenticatedAs($user);
    }

    /**
     * @test
     * @return void
     */

    public function it_logout_success():void
    {

        $user = User::factory()->create([
            'email'=>'andrenik@gmail.com',
        ]);

        $this->actingAs($user)
            ->delete(action([AuthController::class,'logOut']));

        $this->assertGuest();
    }

    /**
     * @test
     * @return void
     */

    public function it_forgotPassword_success():void
    {
        $password = '1234567890';

        $user = User::factory()->create([
            'email'=>'andrenik@gmail.com',
            'password'=>bcrypt($password),
        ]);


        $request = SignUpFormRequest::factory()->create([
            'email'=>$user->email,
            'password'=>$password
        ]);

        $response = $this->post(action([AuthController::class, 'forgotPassword']),$request);

        $this->actingAs($user);

        $response->assertRedirect(route('home'));

    }


    /**
     * @test
     * @return void
     */

    public function it_store_success():void
    {
        Notification::fake();
        Event::fake();

        $request = SignUpFormRequest::factory()->create([
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

        $response->assertValid();

        $this->assertDatabaseHas('users',[
            'email'=>$request['email']
        ]);

        $user = User::query()
            ->where('email',$request['email'])
            ->first();

        Event::assertDispatched(Registered::class);
        Event::assertListening(Registered::class, SendEmailNewUserListener::class);

        $event = new Registered($user);
        $listener = new SendEmailNewUserListener();
        $listener->handle($event);

        Notification::assertSentTo($user,NewUserNotification::class);

        $this->assertAuthenticatedAs($user);

        $response->assertRedirect(route('home'));
    }

}
