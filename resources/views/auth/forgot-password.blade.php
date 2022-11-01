@extends('layouts.auth')

@section('title', 'Забыли пароль')

@section('content')

    <x-form.auth-forms title="Забыли пароль" action="{{route('password.email')}}" method="POST">

        @csrf

            <x-form.text-input
            name="email"
            type="email"
            placeholder="E-mail"
            requred="true"

            :isError="$errors->has('email')"
            />

        @error('email')
            <x-form.error>
                {{$message}}
            </x-form.error>
        @enderror



        {{-- <input type="password" class="w-full h-14 px-4 rounded-lg border border-[#A07BF0] bg-white/20 focus:border-pink focus:shadow-[0_0_0_2px_#EC4176] outline-none transition text-white placeholder:text-white text-xxs md:text-xs font-semibold" placeholder="Пароль" required> --}}
        <x-form.primary-button>
            Отправить
        </x-form.primary-button>


        <x-slot:socialAuth>

        </x-slot:socialAuth>

        <x-slot:buttons>
            <div class="space-y-3 mt-5">
                <div class="text-xxs md:text-xs"><a href="{{route('login')}}" class="text-white hover:text-white/70 font-bold">Вспомнил пароль</a></div>
            </div>
        </x-slot:buttons>

    </x-form.auth-forms>
@endsection
