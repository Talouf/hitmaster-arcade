<!-- resources/views/news/show.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 bg-gray-900 text-white">
    <h1 class="text-4xl font-bold mb-4">{{ htmlspecialchars($newsItem->title) }}</h1>
    <img src="{{ htmlspecialchars($newsItem->image_url) }}" alt="{{ htmlspecialchars($newsItem->title) }}" class="w-full max-h-96 object-cover rounded-lg mb-4">
    <div class="bg-gray-800 p-6 rounded-lg shadow-md">
        <p class="text-gray-300 leading-relaxed">{{ htmlspecialchars($newsItem->content) }}</p>
    </div>
</div>

@endsection