@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 ">
    <h1 class="text-3xl font-bold mb-6 text-white">Edit Product</h1>
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="bg-gray-800 p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-gray-300 text-sm font-bold mb-2">Name</label>
            <input type="text" name="name" id="name" value="{{ $product->name }}" class="w-full bg-gray-700 text-white border border-gray-600 rounded py-2 px-3 focus:outline-none focus:border-indigo-500" required>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-300 text-sm font-bold mb-2">Description</label>
            <textarea name="description" id="description" rows="5" class="w-full bg-gray-700 text-white border border-gray-600 rounded py-2 px-3 focus:outline-none focus:border-indigo-500" required>{{ $product->description }}</textarea>
        </div>
        <div class="mb-4">
            <label for="details" class="block text-gray-300 text-sm font-bold mb-2">Details</label>
            <textarea name="details" id="details" rows="5" class="w-full bg-gray-700 text-white border border-gray-600 rounded py-2 px-3 focus:outline-none focus:border-indigo-500">{{ $product->details }}</textarea>
        </div>
        <div class="mb-4">
            <label for="price" class="block text-gray-300 text-sm font-bold mb-2">Price</label>
            <input type="number" step="0.01" name="price" id="price" value="{{ $product->price }}" class="w-full bg-gray-700 text-white border border-gray-600 rounded py-2 px-3 focus:outline-none focus:border-indigo-500" required>
        </div>
        <div class="mb-4">
            <label for="stock_quantity" class="block text-gray-300 text-sm font-bold mb-2">Stock Quantity</label>
            <input type="number" name="stock_quantity" id="stock_quantity" value="{{ $product->stock_quantity }}" class="w-full bg-gray-700 text-white border border-gray-600 rounded py-2 px-3 focus:outline-none focus:border-indigo-500" required>
        </div>
        <div class="mb-4">
            <label for="image" class="block text-gray-300 text-sm font-bold mb-2">Image</label>
            @if($product->image)
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover mb-2">
            @endif
            <input type="file" name="image" id="image" class="w-full bg-gray-700 text-white border border-gray-600 rounded py-2 px-3 focus:outline-none focus:border-indigo-500">
        </div>
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update Product</button>
    </form>
</div>
@endsection