<!-- cart/show.blade.php -->

@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Shopping Cart</h1>
    <div>
        <table class="table-auto w-full">
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
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->quantity * $item->price }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <form action="{{ route('cart.checkout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Proceed to Checkout</button>
        </form>
    </div>
</div>
@endsection
