@extends('layouts.app')

@section('title', 'Contact - HitMaster Arcade')

@section('content')
<section class="text-center mb-8">
    <h1 class="text-4xl font-bold">Nous contacter</h1>
    <p class="text-gray-400 mt-4">Nous sommes là pour répondre à toutes vos questions.</p>
    <form class="mt-8 max-w-lg mx-auto">
        <div class="mb-4">
            <label for="name" class="block text-left">Nom:</label>
            <input type="text" id="name" class="w-full bg-gray-700 border border-gray-600 rounded py-2 px-4">
        </div>
        <div class="mb-4">
            <label for="email" class="block text-left">Email:</label>
            <input type="email" id="email" class="w-full bg-gray-700 border border-gray-600 rounded py-2 px-4">
        </div>
        <div class="mb-4">
            <label for="message" class="block text-left">Message:</label>
            <textarea id="message" rows="5" class="w-full bg-gray-700 border border-gray-600 rounded py-2 px-4"></textarea>
        </div>
        <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded">Envoyer</button>
    </form>
</section>
@endsection

