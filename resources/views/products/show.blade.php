@extends('layouts.app')

@section('content')
<div class="container mx-auto py-16">
    <div class="bg-gray-800 p-8 rounded">
        <h2 class="text-4xl font-bold text-center">{{ htmlspecialchars($product->name) }}</h2>
        <img src="{{ asset('/' . $product->image) }}" alt="{{ htmlspecialchars($product->name) }}"
            class="h-64 w-full object-cover mt-4 rounded">
        <p class="mt-4 text-xl">{{ htmlspecialchars($product->description) }}</p>
        <p class="mt-4 text-2xl">{{ $product->price }}€</p>
        <button onclick="addToCart(<?= $product->id ?>)" class="bg-blue-600 text-white rounded py-2 px-4 mt-4">Ajouter
            au Panier</button>
    </div>

    <div class="mt-8">
        <h3 class="text-2xl font-bold">Avis</h3>
        @foreach ($product->reviews as $review)
            <div class="bg-gray-700 p-4 rounded mt-4">
                <p>{{ htmlspecialchars($review->content) }}</p>
                <p class="mt-2 text-gray-300">- {{ htmlspecialchars($review->user->name) }} - Note: {{ $review->rating }}/5</p>
                </p>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        @auth
            <h3 class="text-2xl font-bold">Notez le produit</h3>
            <form action="{{ route('reviews.store') }}" method="POST" class="bg-gray-700 p-4 rounded mt-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="mt-4">
                    <label for="note">Note</label>
                    <select name="rating" id="note" class="bg-gray-800 text-white rounded mt-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="mt-4">
                    <label for="content">Avis</label>
                    <textarea name="content" id="content"
                        class="bg-gray-800 text-white rounded mt-2 w-full h-24"></textarea>
                </div>
                <button type="submit" class="bg-blue-600 text-white rounded py-2 px-4 mt-4">Envoyer</button>
            </form>
        @endauth
    </div>
</div>
@endsection