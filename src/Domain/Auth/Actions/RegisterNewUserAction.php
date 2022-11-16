<?php


namespace Domain\Auth\Actions;


use App\Models\User;
use Domain\Auth\Contract\RegisterNewUserContract;

use Domain\Auth\DataTransferObjects\NewUserDTO;
use Illuminate\Auth\Events\Registered;

class RegisterNewUserAction implements RegisterNewUserContract

{
    public function __invoke(NewUserDTO $data)
    {
        $user = User::query()->create([
            'name'=> $data->name,
            'email'=> $data->email,
            'password'=> bcrypt($data->password),
        ]);

        event(new Registered($user));

        auth()->login($user);

    }

}
