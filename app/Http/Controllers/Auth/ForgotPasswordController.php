<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordFormRequest;
use App\Http\Requests\ResetPasswordFormRequest;
use App\Http\Requests\SignInFormRequest;
use App\Http\Requests\SignUpFormRequest;
use Carbon\Factory;
use Domain\Auth\Contract\RegisterNewUserContract;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Console\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Laravel\Socialite\Facades\Socialite;

class ForgotPasswordController extends Controller
{

    public function page():Factory|View|Application|RedirectResponse
    {
        return view('auth.forgot-password');
    }

    public function handle(ForgotPasswordFormRequest $request):RedirectResponse
    {

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT){
            flash()->info(__($status));

            return back();
        }
        return back()->withErrors(['email'=>($status)]);
    }


}
