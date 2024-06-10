<!-- In resources/views/checkout/error.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Error</h1>
    <p>{{ session('error') }}</p>
    <a href="{{ route('checkout') }}" class="btn btn-primary">Go back to Checkout</a>
</div>
@endsection