<?php


namespace Auth\Actions;


use Domain\Auth\Contract\RegisterNewUserContract;
use Domain\Auth\DataTransferObjects\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterNewUserActionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */

    public function it_success_register_new_user():void
    {
        $this->assertDatabaseMissing('users',['email'=>'testing@gmail.com']);

        $action = app(RegisterNewUserContract::class);

        $action(NewUserDTO::make('Test','testing@gmail.com','1234567890'));

        $this->assertDatabaseHas('users',['email'=>'testing@gmail.com']);
    }

}
