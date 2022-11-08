<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordFormRequest;
use App\Http\Requests\ResetPasswordFormRequest;
use App\Http\Requests\SignInFormRequest;
use App\Http\Requests\SignUpFormRequest;
use Carbon\Factory;
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

class _Controller extends Controller
{
//    public function index():Factory|View|Application|RedirectResponse
//    {
//        return view('auth.index');
//    }
//
//    public function signUp()
//    {
//        return view('auth.sign-up');
//    }

//    public function forgot()
//    {
//        return view('auth.forgot-password');
//    }

//    public function signIn(SignInFormRequest $request):RedirectResponse
//    {
//        if(!auth()->attempt($request->validated())){
//
//            return back()->withErrors([
//                'email' => 'The provided credentials do not match our records.',
//            ])->onlyInput('email');
//        }
//
//        $request->session()->regenerate();
//
//        return redirect()
//                ->intended(route('home'));
//
//    }

//    public function store(SignUpFormRequest $request):RedirectResponse
//    {
//        $user = User::query()->create([
//            'name'=> $request->get('name'),
//            'email'=> $request->get('email'),
//            'password'=> bcrypt($request->get('password')),
//        ]);
//
//        event(new Registered($user));
//
//        auth()->login($user);
//
//        return redirect()
//                ->intended(route('home'));
//
//    }



//    public function forgotPassword(ForgotPasswordFormRequest $request)
//    {
//
//        $status = Password::sendResetLink(
//            $request->only('email')
//        );
//
//        if ($status === Password::RESET_LINK_SENT){
//            flash()->info(__($status));
//
//            return back();
//        }
//        return back()->withErrors(['email'=>($status)]);
//    }

//    public function reset(string $token):Factory|View|Application
//    {
//
//            return view('auth.reset-password', ['token' => $token]);
//    }

//    public function resetPassword(ResetPasswordFormRequest $request):RedirectResponse
//    {
//
//        $status = Password::reset(
//            $request->only('email', 'password', 'password_confirmation', 'token'),
//            function ($user, $password) {
//                $user->forceFill([
//                    'password' => bcrypt($password)
//                ])->setRememberToken(str()->random(60));
//
//                $user->save();
//
//                event(new PasswordReset($user));
//            }
//        );
//
//        if ($status === Password::PASSWORD_RESET){
//            flash()->info(__($status));
//
//            return redirect()->route('login');
//        }
//        return back()->withErrors(['email'=>($status)]);
////
////        return $status === Password::PASSWORD_RESET
////                    ? redirect()->route('login')->with('message', __($status))
////                    : back()->withErrors(['email' => [__($status)]]);
//    }

//    public function github()
//    {
//
//         return Socialite::driver('github')->redirect();
//
//    }
//
//    public function githubCallback()
//    {
//        $githubUser = Socialite::driver('github')->user();
//
//        $user = User::query()->updateOrCreate([
//            'github_id' => $githubUser->id,
//        ], [
//            'name' => $githubUser->name ?? $githubUser->id,
//            'email' => $githubUser->email,
//            'password'=>bcrypt(str()->random(20)),
//        ]);
//
//        auth()->login($user);
//
//        return redirect()->intended(route('home'));
//    }
}
