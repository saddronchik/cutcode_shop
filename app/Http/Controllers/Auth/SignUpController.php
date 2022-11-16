<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpFormRequest;
use Domain\Auth\Contract\RegisterNewUserContract;
use Domain\Auth\DataTransferObjects\NewUserDTO;
use Illuminate\Http\RedirectResponse;

class SignUpController extends Controller
{

    public function page()
    {
        return view('auth.sign-up');
    }

    public function handle(SignUpFormRequest $request, RegisterNewUserContract $action):RedirectResponse
    {
//        $dto = new NewUserDTO(
//            $request->get('name'),
//            $request->get('email'),
//            $request->get('password')
//        );

//        NewUserDTO::make('name','email','password');

        $action(NewUserDTO::fromRequest($request));

        return redirect()
                ->intended(route('home'));

    }


}
