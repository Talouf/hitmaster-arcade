@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Checkout</h1>
    <div>
        <ul>
            @foreach($cartItems as $item)
                <li>{{ $item->product->name }} - {{ $item->quantity }} x ${{ $item->price }}</li>
            @endforeach
        </ul>
        <button id="checkout-button" class="btn btn-primary">Complete Order</button>
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
