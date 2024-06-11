@extends('layouts.app')

@section('content')

<!-- Derniers Produits -->
<section class="text-center py-16 bg-black">
    <h2 class="text-4xl font-bold text-white">Derniers Produits</h2>
    <p class="text-lg mt-4 text-gray-400">Améliorez votre confort de jeu avec nos nouvelles box</p>
    <button class="mt-4 px-6 py-2 bg-red-600 text-white rounded"><a href="{{ route('products.index') }}">Explorer</a></button>
    <div class="mt-8 flex justify-center space-x-8">
        @foreach ($latestProducts as $product)
        <div class="bg-gray-800 p-4 rounded">
            <img src="{{ asset('/' . $product->image) }}" alt="{{ $product->name }}" class="h-40 w-full object-cover">
            <h3 class="text-xl mt-2 text-white">{{ $product->name }} - {{ $product->price }}€</h3>
            <a href="{{ route('product.show', $product->id) }}" class="mt-2 block px-4 py-2 bg-red-600 text-white rounded">Voir Produit</a>
            <button onclick="addToCart({{ $product->id }})" class="bg-blue-600 text-white rounded py-2 px-4 mt-4">Ajouter au Panier</button>
        </div>
        @endforeach
    </div>
</section>

<!-- Dernières News -->
<section class="bg-gray-800 py-16 text-center">
    <h2 class="text-4xl font-bold text-white">Dernières News</h2>
    <div class="mt-8 flex justify-center space-x-8">
        @foreach ($latestNews as $news)
        <div class="bg-gray-700 p-4 rounded w-1/3">
            <h3 class="text-2xl text-white">{{ htmlspecialchars($news->title) }}</h3>
            <p class="mt-2 text-red-600"><a href="{{ route('news.show', $news->id) }}">Continuer la lecture &raquo;</a></p>
            <img src="{{ $news->image ? asset('images/' . $news->image) : asset('images/default-image.png') }}" alt="{{ htmlspecialchars($news->title) }}">
        </div>
        @endforeach
    </div>
    <a href="{{ route('news.index') }}" class="mt-4 inline-block px-6 py-2 bg-red-600 text-white rounded">VOIR TOUT</a>
</section>

<!-- Avis de nos clients -->
<div class="text-center mb-8 bg-black py-16">
    <h2 class="text-4xl font-bold text-white">Avis de nos clients</h2>
    <div class="flex justify-center space-x-8 mt-8">
        @foreach ($reviews as $review)
        <div class="bg-gray-800 p-4 rounded w-1/3">
            <p class="text-white">"{{ htmlspecialchars($review->content) }}"</p>
            <p class="mt-2 text-red-600">{{ htmlspecialchars($review->user->name) }}</p>
            <p class="mt-2 text-gray-400">Note: {{ htmlspecialchars($review->rating) }}/5</p>
        </div>
        @endforeach
    </div>
</div>

@endsection