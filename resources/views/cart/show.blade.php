@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4 text-center">Panier</h1>
    <div class="text-center">
        <p class="text-lg">Total de produits: <span id="total-products">{{ $totalProducts }}</span></p>
        @if($cartItems->isEmpty())
            <p class="text-lg">Votre panier est vide.</p>
        @else
            <table class="table-auto w-full border border-gray-200">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4 border-b text-center">Produit</th>
                        <th class="py-2 px-4 border-b text-center">Quantité</th>
                        <th class="py-2 px-4 border-b text-center">Prix</th>
                        <th class="py-2 px-4 border-b text-center">Total</th>
                        <th class="py-2 px-4 border-b text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                        <tr id="cart-item-{{ $item->product_id }}" class="hover:bg-gray-600">
                            <td class="py-2 px-4 border-b text-center">
                                @if($item->product)
                                    {{ $item->product->name }}
                                @else
                                    Product not found
                                @endif
                            </td>
                            <td class="py-2 px-4 border-b text-center quantity">{{ $item->quantity }}</td>
                            <td class="py-2 px-4 border-b text-center">
                                @if($item->product)
                                    {{ number_format($item->product->price, 2) }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="py-2 px-4 border-b text-center">
                                @if($item->product)
                                    {{ number_format($item->quantity * $item->product->price, 2) }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="py-2 px-4 border-b text-center">
                                <div class="flex items-center justify-center">
                                    <button
                                        onclick="addToCart('{{ $item->product_id }}')"
                                        class="bg-green-600 text-white rounded py-2 px-4 mr-2">+</button>
                                    <select id="quantity-{{ $item->product_id }}"
                                        class="bg-red-600 text-white rounded py-2 px-4 mr-2">
                                        @for ($i = 1; $i <= $item->quantity; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                    <button
                                        onclick="removeFromCart('{{ $item->product_id }}')"
                                        class="bg-red-600 text-white rounded py-2 px-4">Supprimer</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p id="cart-total-container" class="text-lg mt-4">
                Total: $<span id="cart-total">{{ number_format($cartItems->sum(function ($item) {
                    return $item->quantity * $item->product->price;
                }), 2) }}</span>
            </p>
            <form id="checkout-form" action="{{ route('checkout') }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="btn btn-primary bg-blue-500 text-white py-2 px-4 rounded">
                    Passer au checkout
                </button>
            </form>
        @endif
    </div>
</div>
@endsection