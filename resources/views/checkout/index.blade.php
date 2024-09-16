@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4 text-center">Checkout</h1>
    <div>
        <ul class="list-none">
            @foreach($cartItems as $item)
                <li class="flex items-center mb-4">
                    <img src="{{ asset('/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover mr-4">
                    <span class="text-lg">{{ $item->product->name }} - {{ $item->quantity }} x ${{ $item->price }}</span>
                </li>
            @endforeach
        </ul>
        <div class="mt-4">
            <p class="text-xl font-bold">Total: ${{ $cartItems->sum(function($item) { return $item->quantity * $item->price; }) }}</p>
        </div>
        <button id="checkout-button" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded">Complete Order</button>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe("{{ env('STRIPE_KEY') }}");
    var checkoutButton = document.getElementById('checkout-button');

    checkoutButton.addEventListener('click', function () {
        stripe.redirectToCheckout({
            sessionId: '{{ $sessionId }}'
        }).then(function (result) {
            if (result.error) {
                alert(result.error.message);
            }
        });
    });
</script>
@endsection