<!-- resources/views/cart/show.blade.php -->

@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')

<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Shopping Cart</h1>
    <div>
        @if(empty($cartItems))
            <p>Your cart is empty.</p>
        @else
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->product->price }}</td>
                            <td>{{ $item->quantity * $item->product->price }}</td>
                            <td>
                            <button onclick="removeFromCart('{{ $item->product_id }}')" class="bg-red-600 text-white rounded py-2 px-4">Remove</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <form action="{{ route('cart.checkout') }}" method="POST">
                @csrf
                <div>
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" required>
                </div>
                <div>
                    <label for="city">City</label>
                    <input type="text" name="city" id="city" required>
                </div>
                <div>
                    <label for="state">State</label>
                    <input type="text" name="state" id="state" required>
                </div>
                <div>
                    <label for="zip_code">Zip Code</label>
                    <input type="text" name="zip_code" id="zip_code" required>
                </div>
                <div>
                    <label for="country">Country</label>
                    <input type="text" name="country" id="country" required>
                </div>
                <button type="submit" class="btn btn-primary">Proceed to Checkout</button>
            </form>
        @endif
    </div>
</div>
@endsection