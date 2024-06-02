@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Products</h1>
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p class="card-text"><strong>${{ $product->price }}</strong></p>
                        <a href="{{ route('product.show', $product->id) }}" class="btn btn-primary">View Product</a>
                        <button onclick="addToCart('{{ $product->id }}')" class="btn btn-secondary">Add to Cart</button>
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
