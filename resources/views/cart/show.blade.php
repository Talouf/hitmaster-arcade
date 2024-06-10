<!-- resources/views/cart/show.blade.php -->

@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')

<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Shopping Cart</h1>
    <div>
        <p>Total Products: <span id="total-products">{{ $totalProducts }}</span></p>
        @if($cartItems->isEmpty())
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
                        <tr id="cart-item-{{ $item->product_id }}">
                            <td>{{ $item->product->name }}</td>
                            <td class="quantity">{{ $item->quantity }}</td>
                            <td>{{ $item->product->price }}</td>
                            <td>{{ $item->quantity * $item->product->price }}</td>
                            <td>
                                <div class="flex items-center">
                                    <select id="quantity-{{ $item->product_id }}"
                                        class="bg-red-600 text-white rounded py-2 px-4 mr-2">
                                        @for ($i = 1; $i <= $item->quantity; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                    <button
                                        onclick="removeFromCart('{{ $item->product_id }}', document.getElementById('quantity-{{ $item->product_id }}').value)"
                                        class="bg-red-600 text-white rounded py-2 px-4">Remove</button>
                                </div>
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
                <form action="{{ route('checkout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Proceed to Checkout</button>
                </form>
            </form>
        @endif
    </div>
</div>
@endsection