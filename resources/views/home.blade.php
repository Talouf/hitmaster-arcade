@extends('layouts.app')

@section('content')

<!-- Derniers Produits -->
<section class="text-center py-16">
    <h2 class="text-4xl font-bold text-white"
        style="font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 36px;">Derniers Produits</h2>
    <p class="text-lg mt-4 text-gray-400" style="font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 14px;">
        Améliorez votre confort de jeu avec nos nouvelles box</p>
    <button class="mt-4 px-6 py-2 bg-red-600 text-white rounded"><a
            href="{{ route('products.index') }}">Explorer</a></button>
    <div class="mt-8 flex justify-center space-x-8">
        @foreach ($latestProducts as $product)
            <div class="p-4 rounded product-item">
                <img src="{{ asset('/' . $product->image) }}" alt="{{ $product->name }}"
                    class="h-40 w-full object-cover shadow-lg"
                    style="box-shadow: inset -20px -18px 20px 0px rgba(230, 57, 70, 0.5)8">
                <h3 class="text-xl mt-2 text-white"
                    style="font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 16px;">{{ $product->name }} -
                    {{ $product->price }}€
                </h3>
                <a href="{{ route('product.show', $product->id) }}"
                    class="mt-2 block px-4 py-2 bg-red-600 text-white rounded">Voir Produit</a>
                <button onclick="addToCart({{ $product->id }}, event)"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Ajouter au Panier
                </button>
            </div>
        @endforeach
    </div>
</section>

<!-- Dernières News -->
<div class="home_border_top"></div>
<section class="py-16 text-center">
    <h2 class="text-4xl font-bold text-white"
        style="font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 36px;">Dernières News</h2>
    <div class="mt-8 flex flex-wrap justify-center">
        @foreach ($latestNews as $news)
            <div class="p-4 w-full sm:w-1/2 md:w-1/3 lg:w-1/4 news-item">
                <div class="bg-gray-800 rounded-lg overflow-hidden h-full flex flex-col">
                    <img src="{{ $news->image ? asset('images/' . $news->image) : asset('images/default-image.png') }}"
                        alt="{{ htmlspecialchars($news->title) }}" class="w-full h-48 object-cover">
                    <div class="p-4 flex-grow flex flex-col justify-between">
                        <h3 class="text-xl text-white mb-2" style="font-family: 'Roboto', sans-serif; font-weight: 400;">
                            {{ htmlspecialchars($news->title) }}
                        </h3>
                        <p class="mt-2 text-red-600">
                            <a href="{{ route('news.show', $news->id) }}" class="hover:underline">Continuer la lecture
                                &raquo;</a>
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <a href="{{ route('news.index') }}"
        class="mt-8 inline-block px-6 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition duration-300">VOIR
        TOUT</a>
</section>

<!-- Avis de nos clients -->
<div class="home_border_top"></div>
<div class="text-center mb-8 py-16">
    <h2 class="text-4xl font-bold text-white"
        style="font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 36px;">Avis de nos clients</h2>
    <div class="reviews-container mt-8">
        @foreach ($reviews as $review)
            <div class="review-item review_bg bg-gray-800 p-4 rounded">
                <p class="text-black" style="font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 16px;">
                    "{{ htmlspecialchars($review->content) }}"</p>
                <p class="mt-2 text-red-600" style="font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 14px;">
                    {{ htmlspecialchars($review->user->name) }}
                </p>
                <p class="mt-1 text-black" style="font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 14px;">
                    Note: {{ htmlspecialchars($review->rating) }}/5</p>
            </div>
        @endforeach
    </div>
</div>

@endsection