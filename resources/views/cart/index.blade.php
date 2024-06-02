@extends('layouts.app')

@section('title', 'Cart')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Your Cart</h1>
    @if($cartItems->isEmpty())
        <p>Your cart is empty.</p>
    @else
        <table class="table-auto w-full mb-4">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ $item->price }}</td>
                        <td>${{ $item->quantity * $item->price }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <form action="{{ route('cart.checkout') }}" method="POST">
            @csrf
            <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="{{ env('STRIPE_KEY') }}"
                    data-amount="{{ $cartItems->sum('price') * 100 }}"
                    data-name="Your Company Name"
                    data-description="Order Payment"
                    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                    data-locale="auto"
                    data-currency="usd">
            </script>
        </form>
    @endif
</div>
@endsection
