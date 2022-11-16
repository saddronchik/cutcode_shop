<?php


namespace Domain\Auth\DataTransferObjects;


use Illuminate\Http\Request;
use Support\Traits\Makeable;

class NewUserDTO
{
    use Makeable;

    public function __construct(public string $name, public string $email, public string $password,)
    {

    }

    public static function fromRequest(Request $request)
    {
        return self::make(...$request->only(['name','email','password']));

//        return new self(
//            $request->get('name'),
//            $request->get('email'),
//            $request->get('password')
//        );
    }

}
