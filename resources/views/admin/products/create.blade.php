@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-white">Ajouter un nouveau produit</h1>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded-md mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-gray-800 p-6 rounded-lg shadow-md">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-300 text-sm font-bold mb-2">Product Name</label>
            <input type="text" name="name" id="name" class="w-full bg-gray-700 text-white border border-gray-600 rounded py-2 px-3 focus:outline-none focus:border-indigo-500" required>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-300 text-sm font-bold mb-2">Description</label>
            <textarea name="description" id="description" class="w-full bg-gray-700 text-white border border-gray-600 rounded py-2 px-3 focus:outline-none focus:border-indigo-500" required></textarea>
        </div>
        <div class="mb-4">
            <label for="details" class="block text-gray-300 text-sm font-bold mb-2">Details</label>
            <textarea name="details" id="details" class="w-full bg-gray-700 text-white border border-gray-600 rounded py-2 px-3 focus:outline-none focus:border-indigo-500"></textarea>
        </div>
        <div class="mb-4">
            <label for="price" class="block text-gray-300 text-sm font-bold mb-2">Price</label>
            <input type="number" step="0.01" name="price" id="price" class="w-full bg-gray-700 text-white border border-gray-600 rounded py-2 px-3 focus:outline-none focus:border-indigo-500" required>
        </div>
        <div class="mb-4">
            <label for="stock_quantity" class="block text-gray-300 text-sm font-bold mb-2">Stock Quantity</label>
            <input type="number" name="stock_quantity" id="stock_quantity" class="w-full bg-gray-700 text-white border border-gray-600 rounded py-2 px-3 focus:outline-none focus:border-indigo-500" required>
        </div>
        <div class="mb-4">
            <label for="image" class="block text-gray-300 text-sm font-bold mb-2">Image</label>
            <input type="file" name="image" id="image" class="w-full bg-gray-700 text-white border border-gray-600 rounded py-2 px-3 focus:outline-none focus:border-indigo-500" required>
        </div>
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Ajouter produit</button>
    </form>
</div>
@endsection