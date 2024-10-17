@extends('layouts.app')

<x-localize />

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-gray-800 rounded-lg overflow-hidden shadow-lg">
        <img src="{{ $newsItem->image_url ?: asset('images/default-news-image.jpg') }}"
            alt="{{ $newsItem->localized_title }}" class="w-full h-64 object-cover object-center">
        <div class="p-6">
            <h1 class="text-3xl font-bold mb-2 text-white">{{ $newsItem->localized_title }}</h1>
            <div class="flex items-center text-gray-400 text-sm mb-4">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
                {{ $newsItem->post_date->translatedFormat('d M Y') }}
            </div>
            <div class="prose prose-lg text-gray-300 leading-relaxed mb-6">
                {!! $newsItem->localized_content !!}
            </div>
            @if($newsItem->admin)
                <div class="text-sm text-gray-400 mt-4">
                    {{ __('messages.posted_by') }}: {{ $newsItem->admin->name }}
                </div>
            @endif
        </div>
    </div>

    <div class="mt-8 flex justify-between">
        @if($previousNews)
            <a href="{{ route('news.show', $previousNews->id) }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300">
                &larr; {{ __('messages.previous_news') }}
            </a>
        @else
            <div></div>
        @endif

        @if($nextNews)
            <a href="{{ route('news.show', $nextNews->id) }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300">
                {{ __('messages.next_news') }} &rarr;
            </a>
        @else
            <div></div>
        @endif
    </div>

    <div class="mt-12">
        <h2 class="text-2xl font-bold text-white mb-4">{{ __('messages.related_news') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($relatedNews as $relatedItem)
                <div class="bg-gray-800 rounded-lg overflow-hidden shadow-md">
                    <img src="{{ $relatedItem->image_url ?: asset('images/default-news-image.jpg') }}"
                        alt="{{ $relatedItem->localized_title }}" class="w-full h-40 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-white mb-2">{{ $relatedItem->localized_title }}</h3>
                        <p class="text-gray-400 text-sm mb-2">{{ $relatedItem->post_date->translatedFormat('d M Y') }}</p>
                        <a href="{{ route('news.show', $relatedItem->id) }}" class="text-blue-400 hover:text-blue-300">
                            {{ __('messages.read_more') }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection