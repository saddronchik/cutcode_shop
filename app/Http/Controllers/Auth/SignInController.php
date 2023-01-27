<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordFormRequest;
use App\Http\Requests\ResetPasswordFormRequest;
use App\Http\Requests\SignInFormRequest;
use App\Http\Requests\SignUpFormRequest;
use Carbon\Factory;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Console\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Laravel\Socialite\Facades\Socialite;
use Support\SessionRegenerator;

class SignInController extends Controller
{
    public function page():Factory|View|Application|RedirectResponse
    {
        return view('auth.login');
    }

    public function handle(SignInFormRequest $request):RedirectResponse
    {
        if(!auth()->attempt($request->validated())){
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }
        $request->session()->regenerate();

//        SessionRegenerator::run();

        return redirect()
                ->intended(route('home'));

    }
    public function logOut():RedirectResponse
    {
//        SessionRegenerator::run(fn()=>auth()->logout());
        SessionRegenerator::run(fn()=>auth()->logout());
//        request()->session()->invalidate();
//
//        request()->session()->regenerateToken();

        return redirect()->route('home');
    }

}
