@extends('layouts.app')

<x-localize />

@section('content')
<div class="container mx-auto px-4 text-white">
    <h1 class="text-3xl font-bold text-center my-8">{{ __('messages.news') }}</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($news as $newsItem)
            <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg">
                <img src="{{ $newsItem->image_url }}" alt="{{ $newsItem->localized_title }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-xl font-semibold mb-2">{{ $newsItem->localized_title }}</h3>
                    <p class="text-sm text-gray-400 mb-4">{{ $newsItem->post_date->translatedFormat('d M Y') }}</p>
                    <p class="text-gray-400 mb-4">{{ Str::limit($newsItem->localized_content, 100) }}</p>
                    <a href="{{ route('news.show', $newsItem->id) }}" class="inline-block bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition duration-300">
                        {{ __('messages.read_more') }}
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-8">
        {{ $news->links() }}
    </div>
</div>
@endsection