<?php


namespace Auth\DTOs;


use App\Http\Requests\SignUpFormRequest;
use Domain\Auth\DataTransferObjects\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewUserDTOTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */

    public function it_instance_created_from_form_request():void
    {
        //В перменную записываеи метод класса ДТО он принимает массив реквеста приходящий из реквест - контроллера SignUP
        //который в свою очередь использует

        $dto = NewUserDTO::fromRequest(new SignUpFormRequest([
            'name'=>'test',
            'email'=>'testing@gmail.com',
            'password'=>'12345678'
        ]));

        $this->assertInstanceOf(NewUserDTO::class,$dto);
    }

}
