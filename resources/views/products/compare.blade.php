@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-center">Comparaison de Produits</h1>
    
    <!-- Desktop comparison table -->
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2">Caractéristique</th>
                    @foreach ($products as $product)
                        <th class="px-4 py-2">{{ $product->name }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border px-4 py-2 font-semibold">Prix</td>
                    @foreach ($products as $product)
                        <td class="border px-4 py-2">{{ $product->price }}€</td>
                    @endforeach
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-semibold">Description</td>
                    @foreach ($products as $product)
                        <td class="border px-4 py-2">{{ $product->description }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-semibold">Image</td>
                    @foreach ($products as $product)
                        <td class="border px-4 py-2">
                            <img src="{{ asset('/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-40 object-cover">
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-semibold">Action</td>
                    @foreach ($products as $product)
                        <td class="border px-4 py-2">
                            <button onclick="addToCart({{ $product->id }}, event)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                                Ajouter au Panier
                            </button>
                        </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Mobile swipeable comparison -->
    <div class="md:hidden">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @foreach ($products as $product)
                    <div class="swiper-slide product-card">
                        <h3 class="text-xl font-bold mb-2">{{ $product->name }}</h3>
                        <img src="{{ asset('/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-40 object-cover mb-4">
                        <p class="mb-2"><strong>Prix:</strong> {{ $product->price }}€</p>
                        <p class="mb-4"><strong>Description:</strong> {{ $product->description }}</p>
                        <button onclick="addToCart({{ $product->id }}, event)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                            Ajouter au Panier
                        </button>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>
@endsection
