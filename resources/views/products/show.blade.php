@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-3xl font-bold mb-4">{{ $product->name }}</h2>
        <img src="{{ asset('/' . $product->image) }}" alt="{{ $product->name }}" class="w-full max-w-md mx-auto mb-4 rounded">
        <p class="text-xl mb-4">{{ $product->description }}</p>
        <p class="text-2xl font-bold mb-4">${{ number_format($product->price, 2) }}</p>
        <p class="mb-4">In stock: {{ $product->stock_quantity }}</p>
        @if($product->stock_quantity > 0)
            <button onclick="addToCart({{ $product->id }})" class="bg-blue-500 text-white py-2 px-4 rounded">Add to Cart</button>
        @else
            <p class="text-red-500">Out of stock</p>
        @endif
    </div>

    <div class="mt-8">
        <h3 class="text-2xl font-bold mb-4">Reviews</h3>
        @foreach ($product->reviews as $review)
            <div class="bg-gray-100 p-4 rounded mb-4">
                <p class="mb-2">{{ $review->content }}</p>
                <p class="text-sm text-gray-600">- {{ $review->user->name }} - Rating: {{ $review->rating }}/5</p>
            </div>
        @endforeach
    </div>

    @auth
        @if(Auth::user()->orders()->whereHas('orderItems', function($query) use ($product) {
            $query->where('product_id', $product->id);
        })->exists())
            <div class="mt-8">
                <h3 class="text-2xl font-bold mb-4">Write a Review</h3>
                <form action="{{ route('reviews.store') }}" method="POST" class="bg-white p-4 rounded">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="mb-4">
                        <label for="rating" class="block mb-2">Rating</label>
                        <select name="rating" id="rating" class="w-full p-2 border rounded">
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="content" class="block mb-2">Review</label>
                        <textarea name="content" id="content" rows="4" class="w-full p-2 border rounded"></textarea>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Submit Review</button>
                </form>
            </div>
        @endif
    @endauth
</div>

<script>
function addToCart(productId) {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(`/cart/add/${productId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ quantity: 1 })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Product added to cart');
            const cartCountElement = document.getElementById('cart-count');
            if (cartCountElement) {
                cartCountElement.textContent = data.cartCount;
            }
        } else {
            alert('Error adding product to cart: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error adding product to cart');
    });
}
</script>
@endsection