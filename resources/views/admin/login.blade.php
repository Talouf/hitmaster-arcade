@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-center ">
        <div class="w-full max-w-md">
            <div class="hadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div class="text-center text-2xl font-bold mb-4">{{ __('Admin Login') }}</div>

                <form method="POST" action="{{ route('admin.login.submit') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="block text-gray-100 text-sm font-bold mb-2">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="email" class="block mt-1 w-full bg-gray-700 text-white border-gray-600 @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-gray-100 text-sm font-bold mb-2">{{ __('Password') }}</label>
                        <input id="password" type="password" class="block mt-1 w-full bg-gray-700 text-white border-gray-600 @error('password') border-red-500 @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            {{ __('Login') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection