@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center">
    <div class="w-full max-w-md">
        <form method="POST" action="{{ route('register') }}" class="shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            <h2 class="text-center text-2xl font-bold text-white mb-6">Register</h2>

            <div class="mb-4">
                <input id="nickname" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-gray-700 text-white" name="nickname" value="{{ old('nickname') }}" required autocomplete="nickname" autofocus placeholder="Nickname">
            </div>

            <div class="mb-4">
                <input id="email" type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-gray-700 text-white" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
            </div>

            <div class="mb-4">
                <input id="password" type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-gray-700 text-white" name="password" required autocomplete="new-password" placeholder="Password">
            </div>

            <div class="mb-6">
                <input id="password_confirmation" type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-gray-700 text-white" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
            </div>

            <div class="flex items-center justify-between">
                <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="{{ route('login') }}">
                    Already registered?
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Register
                </button>
            </div>
        </form>
    </div>
</div>
@endsection