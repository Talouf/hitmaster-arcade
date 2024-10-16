@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold mb-6 text-white">Contactez-nous</h1>

    @if(session('success'))
        <div class="bg-green-500 text-white px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('contact.submit') }}" method="POST" class="max-w-lg">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-400 text-sm mb-2">Nom :</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full bg-white text-gray-900 rounded py-2 px-3 focus:outline-none" required>
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-400 text-sm mb-2">E-mail :</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full bg-white text-gray-900 rounded py-2 px-3 focus:outline-none" required>
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="message" class="block text-gray-400 text-sm mb-2">Message :</label>
            <textarea name="message" id="message" rows="5" class="w-full bg-gray-700 text-white rounded py-2 px-3 focus:outline-none" required>{{ old('message') }}</textarea>
            @error('message')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                Envoyer le message
            </button>
        </div>
    </form>
</div>
@endsection