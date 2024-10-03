@extends('layouts.app')

@section('content')
<div class="flex justify-center min-h-screen">
    <form method="POST" action="{{ route('register') }}" class="w-full max-w-sm p-8 rounded-lg">
        @csrf

        <!-- nickname -->
        <div>
            <x-input-label for="nickname" :value="__('Nickname')" class="text-white font-roboto text-16px" />
            <x-text-input id="nickname" class="block mt-1 w-full" type="text" name="nickname" :value="old('nickname')"
                required autofocus autocomplete="nickname" />
            <x-input-error :messages="$errors->get('nickname')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-white font-roboto text-16px" />
            <x-text-input id="email" class="block mt-1 w-full font-roboto text-16px text-white" type="email"
                name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-white" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-white font-roboto text-16px" />
            <x-text-input id="password" class="block mt-1 w-full font-roboto text-16px text-white" type="password"
                name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-white" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')"
                class="text-white font-roboto text-16px" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full font-roboto text-16px text-white"
                type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-white" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</div>
@endsection