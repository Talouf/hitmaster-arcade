@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4 text-white">Résultats de recherche pour : "{{ $query }}"</h1>

    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-4 text-red-500">Produits</h2>
        @if($products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
                    <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-white mb-2">{{ $product->name }}</h3>
                            <p class="text-gray-400 mb-2">{{ Str::limit($product->description, 100) }}</p>
                            <p class="text-red-500 font-bold">{{ $product->price }}€</p>
                            <a href="{{ route('products.show', $product->id) }}" class="mt-2 inline-block bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">Voir le produit</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-400">Aucun produit trouvé.</p>
        @endif
    </div>

    <div>
        <h2 class="text-xl font-semibold mb-4 text-red-500">News</h2>
        @if($news->count() > 0)
            <div class="space-y-4">
                @foreach($news as $newsItem)
                    <div class="bg-gray-800 rounded-lg shadow-lg p-4">
                        <h3 class="text-lg font-semibold text-white mb-2">{{ $newsItem->title }}</h3>
                        <p class="text-gray-400 mb-2">{{ Str::limit($newsItem->content, 150) }}</p>
                        <a href="{{ route('news.show', $newsItem->id) }}" class="text-red-500 hover:underline">Lire la suite</a>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-400">Aucune news trouvée.</p>
        @endif
    </div>
</div>
@endsection