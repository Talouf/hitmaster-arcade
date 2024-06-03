<!-- resources/views/products/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-4xl font-bold text-center mb-8">Products</h1>
    <div class="flex flex-wrap -mx-4">
        @foreach ($products as $product)
            <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-8">
                <div class="bg-dark-blue shadow-lg rounded-lg overflow-hidden">
                    <img src="{{ asset('/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                        <p class="text-gray-700 mt-2">${{ number_format($product->price, 2) }}</p>
                        <p class="text-gray-700 mt-2">{{ Str::limit($product->description, 100) }}</p>
                        <a href="{{ route('products.show', $product->id) }}" class="mt-4 inline-block bg-red-500 text-white px-4 py-2 rounded">See Product</a>
                        <button onclick="addToCart(<?= $product->id ?>)" class="bg-blue-600 text-white rounded py-2 px-4 mt-4">Ajouter au Panier</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    function addToCart(productId) {
        fetch(`/cart/add/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                quantity: 1 // or any quantity you want to pass
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                // Optionally, update the cart icon count here
            } else {
                alert('Failed to add to cart');
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endsection
