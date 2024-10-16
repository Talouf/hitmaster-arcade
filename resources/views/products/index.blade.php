@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6 text-center">Derniers Produits</h1>
    <p class="text-lg mt-4 text-gray-400 text-center">Améliorez votre confort de jeu avec nos nouvelles box</p>

    <form action="{{ route('products.compare') }}" method="GET" class="mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($products as $product)
                <div class="p-4 rounded product-item bg-gray-800">
                    <img src="{{ asset('/' . $product->image) }}" alt="{{ $product->name }}"
                        class="w-full object-cover shadow-lg mb-4"
                        style="box-shadow: inset -20px -18px 20px 0px rgba(230, 57, 70, 0.5)8">
                    <h3 class="text-xl mt-2 text-white">{{ $product->name }} - {{ $product->price }}€</h3>
                    <a href="{{ route('product.show', $product->id) }}"
                        class="mt-2 block px-4 py-2 bg-red-600 text-white rounded text-center">Voir Produit</a>
                    <button onclick="addToCart({{ $product->id }}, event)"
                        class="mt-2 w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Ajouter au Panier
                    </button>
                    <div class="mt-2 flex items-center">
                        <input type="checkbox" name="product[]" value="{{ $product->id }}" id="compare_{{ $product->id }}" class="mr-2">
                        <label for="compare_{{ $product->id }}" class="text-white">Comparer</label>
                    </div>
                </div>
            @endforeach
        </div>
        <button type="submit" class="mt-4 w-full bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">Comparer les produits sélectionnés</button>
    </form>
</div>
@endsection