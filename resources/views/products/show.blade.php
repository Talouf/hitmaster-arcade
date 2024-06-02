@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container mx-auto px-4">
    <div class="product-details">
        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="mb-4 rounded-lg">
        <h1 class="text-4xl font-bold">{{ $product->name }}</h1>
        <p class="text-gray-400 mt-4">{{ $product->description }}</p>
        <p class="text-primary mt-4">${{ $product->price }}</p>
        <button onclick="addToCart('{{ $product->id }}')" class="btn btn-secondary">Add to Cart</button>
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
