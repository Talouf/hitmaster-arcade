<!-- resources/views/products/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-4xl font-bold text-center mb-8">Produits</h1>
    <div class="flex flex-wrap -mx-4">
        @foreach ($products as $product)
            <div class="w-full md:w-1/2 lg:w-1/2 px-4 mb-8">
                <div class="bg-dark-blue shadow-lg rounded-lg overflow-hidden">
                    <img src="{{ asset('/' . $product->image) }}" alt="{{ $product->name }}" class="w-full">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                        <p class="text-white mt-2">${{ number_format($product->price, 2) }}</p>
                        <p class="text-white mt-2">{{ Str::limit($product->description, 100) }}</p>
                        <a href="{{ route('products.show', $product->id) }}" class="mt-4 inline-block bg-red-500 text-white px-4 py-2 rounded">Voir Produit</a>
                        <button onclick="addToCart(<?= $product->id ?>)" class="bg-blue-600 text-white rounded py-2 px-4 mt-4">Ajouter au Panier</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection