<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordFormRequest;
use App\Http\Requests\ResetPasswordFormRequest;
use App\Http\Requests\SignInFormRequest;
use App\Http\Requests\SignUpFormRequest;
use Carbon\Factory;
use Domain\Auth\Contract\RegisterNewUserContract;
use App\Models\User;
use DomainException;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Console\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class SocialAuthController extends Controller
{
    public function redirect(string $driver):\Symfony\Component\HttpFoundation\RedirectResponse|RedirectResponse
    {

        try {
            return Socialite::driver($driver)->redirect();
        }catch (Throwable $e){
            throw new DomainException('Произошла ошибка или драйвер не поддреживается!');
        }
    }

    public function callback(string $driver): RedirectResponse
    {
        if ($driver !== 'github'){
            throw new DomainException('Драйвер не поддреживается!');
        }

        $githubUser = Socialite::driver($driver)->user();

        $user = User::query()->updateOrCreate([
            $driver.'_id' => $githubUser->getId(),
        ], [
            'name' => $githubUser->getName(),
            'email' => $githubUser->getEmail(),
            'password'=>bcrypt(str()->random(20)),
        ]);

        auth()->login($user);

        return redirect()->intended(route('home'));
    }


}
