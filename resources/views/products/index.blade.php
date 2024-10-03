@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-4xl font-bold text-center mb-8">Produits</h1>
    <div class="flex flex-wrap -mx-4">
        @foreach ($products as $product)
            <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-8"> <!-- Adjust lg:w-1/3 for three items per row on large screens -->
                <div class="bg-dark-blue shadow-lg rounded-lg overflow-hidden h-full"> <!-- Ensure the card takes full height -->
                    <div class="h-64 overflow-hidden"> <!-- Fixed height for the image container -->
                        <img src="{{ asset('/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover"> <!-- Make the image cover the container -->
                    </div>
                    <div class="p-4 flex flex-col justify-between h-auto"> <!-- Added flexbox for equal spacing -->
                        <div>
                            <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                            <p class="text-white mt-2">${{ number_format($product->price, 2) }}</p>
                            <p class="text-white mt-2">{{ Str::limit($product->description, 100) }}</p>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('products.show', $product->id) }}" class="inline-block bg-red-500 text-white px-4 py-2 rounded">Voir Produit</a>
                            <button onclick="addToCart(<?= $product->id ?>)" class="bg-blue-600 text-white rounded py-2 px-4 mt-2">Ajouter au Panier</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
