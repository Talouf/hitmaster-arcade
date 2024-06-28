@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-4xl font-bold text-center mb-8">Add Shipping Information</h1>
    <form action="{{ route('profile.store-shipping-info') }}" method="POST" class="max-w-lg mx-auto p-8 rounded shadow-lg">
        @csrf
        <div class="mb-4">
            <label for="address" class="block text-white font-semibold">Address</label>
            <input type="text" name="address" id="address" class="w-full p-2 border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label for="city" class="block text-white font-semibold">City</label>
            <input type="text" name="city" id="city" class="w-full p-2 border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label for="state" class="block text-white font-semibold">State</label>
            <input type="text" name="state" id="state" class="w-full p-2 border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label for="zip_code" class="block text-white font-semibold">Zip Code</label>
            <input type="text" name="zip_code" id="zip_code" class="w-full p-2 border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label for="country" class="block text-white font-semibold">Country</label>
            <input type="text" name="country" id="country" class="w-full p-2 border border-gray-300 rounded" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Shipping Info</button>
    </form>
</div>
@endsection