@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Contactez-nous</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('contact.submit') }}" method="POST" class="max-w-lg">
    @csrf
    <div class="mb-4">
        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nom :</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" required>
        @error('name')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-4">
        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">E-mail :</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" required>
        @error('email')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-4">
        <label for="message" class="block text-gray-700 text-sm font-bold mb-2">Message :</label>
        <textarea name="message" id="message" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('message') border-red-500 @enderror" required>{{ old('message') }}</textarea>
        @error('message')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
    </div>
    <div class="flex items-center justify-between">
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Envoyer le message
        </button>
    </div>
</form>
</div>
@endsection