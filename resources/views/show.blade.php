@extends('layouts.app')

@section('content')
    <div class="product">
        <h1>{{ $product->name }}</h1>
        <p>{{ $product->description }}</p>
        <p>{{ $product->details }}</p>
        <p>Prix: {{ $product->price }}€</p>
        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
    </div>
@endsection