@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-gray-800 rounded-lg overflow-hidden shadow-lg">
        <img src="{{ htmlspecialchars($newsItem->image_url) }}" alt="{{ htmlspecialchars($newsItem->title) }}" class="w-full h-48 object-cover object-center">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-2 text-white">{{ htmlspecialchars($newsItem->title) }}</h1>
            <p class="text-sm text-gray-400 mb-4">{{ htmlspecialchars($newsItem->created_at->format('d M Y')) }}</p>
            <div class="text-gray-300 leading-relaxed">
                <p>{{ htmlspecialchars($newsItem->content) }}</p>
            </div>
        </div>
    </div>
</div>
@endsection