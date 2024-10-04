<!-- resources/views/news/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 bg-gray-900 text-white">
    <h1 class="text-3xl font-bold text-center my-8">Actualités</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($news as $newsItem)
            <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg">
                @if ($newsItem->image)
                    <img src="{{ asset('images/' . urlencode($newsItem->image)) }}" alt="{{ $newsItem->title }}" class="w-full h-48 object-cover">
                @else
                    <img src="{{ asset('images/default-image.png') }}" alt="Default Image" class="w-full h-48 object-cover">
                @endif
                <div class="p-4">
                    <h3 class="text-xl font-semibold mb-2">{{ $newsItem->title }}</h3>
                    <p class="text-gray-400 mb-4">{{ Str::limit($newsItem->content, 100) }}</p>
                    <a href="{{ route('news.show', $newsItem->id) }}" class="inline-block bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition duration-300">Lire plus</a>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection