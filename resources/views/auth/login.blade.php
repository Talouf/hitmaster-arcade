@php
use Illuminate\Support\Facades\Route;
@endphp
@extends('layouts.app')

@section('content')
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="max-w-md mx-auto shadow-md rounded px-8 pt-6 pb-8 mb-4" style="font-family: 'Roboto', sans-serif; font-weight: 400; color: #FFFFFF;">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <x-input-label for="email" :value="__('Email')" style="font-family: 'Roboto', sans-serif; font-weight: 400; color: #FFFFFF;" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-6">
            <x-input-label for="password" :value="__('Password')" style="font-family: 'Roboto', sans-serif; font-weight: 400; color: #FFFFFF;" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mb-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ml-2 text-sm">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between">
            @if (Route::has('password.request'))
                <a class="underline text-sm dark:text-gray-100 hover:text-gray-300 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ml-3" style="font-family: 'Roboto', sans-serif; font-weight: 400; color: #FFFFFF;">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
@endsection