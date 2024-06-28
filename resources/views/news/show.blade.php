<!-- resources/views/news/show.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold mb-4">{{ htmlspecialchars($newsItem->title) }}</h1>
    <img src="{{ htmlspecialchars($newsItem->image_url) }}" alt="{{ htmlspecialchars($newsItem->title) }}" class="w-full max-h-96 object-cover rounded-lg mb-4">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <p class="text-gray-700 leading-relaxed">{{ htmlspecialchars($newsItem->content) }}</p>
    </div>
</div>
@endsection