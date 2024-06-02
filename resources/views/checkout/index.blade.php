@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Checkout</h2>
    <ul>
        @foreach ($cartItems as $item)
        <li>{{ $item->product->name }} - {{ $item->quantity }} x ${{ $item->price }}</li>
        @endforeach
    </ul>
    <form action="{{ route('checkout.complete') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Complete Order</button>
    </form>
</div>
@endsection
