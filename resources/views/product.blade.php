@extends('layouts.app')

@section('content')
    <div class="product-details">
        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="mb-4 rounded-lg">
        <h1 class="text-4xl font-bold">{{ $product->name }}</h1>
        <p class="text-gray-400 mt-4">{{ $product->details }}</p>
        <p class="text-primary mt-4">{{ $product->price }}€</p>
    </div>
@endsection
