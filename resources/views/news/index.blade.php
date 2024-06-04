<!-- resources/views/news/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>News</h1>
    <div class="flex flex-wrap -mx-4">
        @foreach ($news as $newsItem)
            <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-8">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    @if ($newsItem->image)
                        <img src="{{ asset('images/' . urlencode($newsItem->image)) }}" alt="{{ $newsItem->title }}" class="w-full h-48 object-cover">
                    @else
                        <img src="{{ asset('images/default-image.png') }}" alt="Default Image" class="w-full h-48 object-cover">
                    @endif
                    <div class="p-4">
                        <h3 class="text-lg font-semibold">{{ $newsItem->title }}</h3>
                        <p class="text-gray-700 mt-2">{{ Str::limit($newsItem->content, 100) }}</p>
                        <a href="{{ route('news.show', $newsItem->id) }}" class="mt-4 inline-block bg-red-500 text-white px-4 py-2 rounded">Read more</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
