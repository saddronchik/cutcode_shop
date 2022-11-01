@extends('layouts.auth')

@section('title', 'Восстановление пароля')

@section('content')

    <x-form.auth-forms title="Восстановление пароля" action="{{route('password.update')}}"  method="POST">

        @csrf

        <input type="hidden" name="token" value="{{$token}}"/>

            <x-form.text-input
            name="email"
            type="email"
            placeholder="E-mail"
            requred="true"
            value="{{request('email')}}"
            :isError="$errors->has('email')"
            />

        @error('email')
            <x-form.error>
                {{$message}}
            </x-form.error>
        @enderror

        <x-form.text-input name="password" type="password" placeholder="Пароль" requred="true" :isError="$errors->has('email')" />

            @error('password')
                <x-form.error>
                    {{ $message }}
                </x-form.error>
            @enderror

            <x-form.text-input name="password_confimation" type="password" placeholder="Повторите пароль" requred="true" :isError="$errors->has('password_confimation')" />

            @error('password_confimation')
                <x-form.error>
                    {{ $message }}
                </x-form.error>
            @enderror



        {{-- <input type="password" class="w-full h-14 px-4 rounded-lg border border-[#A07BF0] bg-white/20 focus:border-pink focus:shadow-[0_0_0_2px_#EC4176] outline-none transition text-white placeholder:text-white text-xxs md:text-xs font-semibold" placeholder="Пароль" required> --}}
        <x-form.primary-button>
            Обновить пароль
        </x-form.primary-button>

        <x-slot:socialAuth>

        </x-slot:socialAuth>

        <x-slot:buttons>

        </x-slot:buttons>

    </x-form.auth-forms>
@endsection
