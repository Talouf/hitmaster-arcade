@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4 text-center">Shopping Cart</h1>
    <div class="text-center">
        <p class="text-lg">Total products: <span id="total-products">{{ $totalProducts }}</span></p>
        @if($cartItems->isEmpty())
            <p class="text-lg">Your cart is empty.</p>
        @else
            <table class="w-full border-collapse border border-gray-300 mt-4">
                <thead>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">Product</th>
                        <th class="border border-gray-300 px-4 py-2">Quantity</th>
                        <th class="border border-gray-300 px-4 py-2">Price</th>
                        <th class="border border-gray-300 px-4 py-2">Total</th>
                        <th class="border border-gray-300 px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                        <tr id="cart-item-{{ $item->product_id }}">
                            <td class="border border-gray-300 px-4 py-2">{{ $item->product->name }}</td>
                            <td class="border border-gray-300 px-4 py-2 quantity">{{ $item->quantity }}</td>
                            <td class="border border-gray-300 px-4 py-2">${{ $item->price }}</td>
                            <td class="border border-gray-300 px-4 py-2">${{ $item->quantity * $item->price }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                <button onclick="removeFromCart({{ $item->product_id }}, 1)" class="bg-red-500 text-white rounded py-1 px-2">Remove</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                <p class="text-xl font-bold">Total: ${{ $cartItems->sum(function($item) { return $item->quantity * $item->price; }) }}</p>
            </div>
            <form action="{{ route('checkout') }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Proceed to Checkout</button>
            </form>
        @endif
    </div>
</div>

<script>
function removeFromCart(productId, quantity) {
    fetch(`/cart/remove/${productId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ quantity: quantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error removing item from cart');
        }
    });
}
</script>
@endsection