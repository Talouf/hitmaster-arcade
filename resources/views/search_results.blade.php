@extends('layouts.app')
<x-localize />
@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8 text-white text-center">{{ __('messages.search_results_for') }} "{{ $query }}"</h1>

    <div class="mb-12">
        <h2 class="text-2xl font-semibold mb-6 text-red-500 border-b border-red-500 pb-2">{{ __('messages.products') }}</h2>
        @if($products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($products as $product)
                    <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-xl">
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-white mb-2">{{ $product->name }}</h3>
                            <p class="text-gray-400 mb-4 h-20 overflow-hidden">{{ Str::limit($product->description, 100) }}</p>
                            <p class="text-red-500 font-bold text-xl mb-4">{{ $product->price }}€</p>
                            <a href="{{ route('product.show', $product->id) }}" class="block w-full text-center bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition duration-300">{{ __('messages.view_product') }}</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-400 text-center">{{ __('messages.no_products_found') }}</p>
        @endif
    </div>

    <div>
        <h2 class="text-2xl font-semibold mb-6 text-red-500 border-b border-red-500 pb-2">{{ __('messages.news') }}</h2>
        @if($news->count() > 0)
            <div class="space-y-6">
                @foreach($news as $newsItem)
                    <div class="bg-gray-800 rounded-lg shadow-lg p-6 transition duration-300 ease-in-out hover:bg-gray-700">
                        <h3 class="text-xl font-semibold text-white mb-2">{{ $newsItem->{"title_" . app()->getLocale()} }}</h3>
                        <p class="text-gray-400 mb-4">{{ Str::limit($newsItem->{"content_" . app()->getLocale()}, 200) }}</p>
                        <a href="{{ route('news.show', $newsItem->id) }}" class="inline-block bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition duration-300">{{ __('messages.read_more') }}</a>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-400 text-center">{{ __('messages.no_news_found') }}</p>
        @endif
    </div>
</div>
@endsection