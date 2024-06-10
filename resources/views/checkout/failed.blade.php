<!-- resources/views/checkout/failed.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Checkout Failed</h1>
    <p>There was an issue processing your checkout. Please try again later.</p>
    <a href="{{ route('cart.show') }}" class="btn btn-primary">Return to Cart</a>
</div>
@endsection