@extends('layouts.app')

@section('content')
<section class="text-center mb-8">
    <h1 class="text-3xl font-bold">Toutes les News</h1>
    <div class="flex justify-center mt-4 space-x-4">
        @foreach ($news as $newsItem)
            <div class="card">
                <h3 class="text-2xl font-bold">
                    <a href="{{ route('news.show', $newsItem->id) }}">{{ $newsItem->title }}</a>
                </h3>
                <p class="text-gray-400">{{ $newsItem->post_date }}</p>
                <p>{{ Str::limit($newsItem->content, 150) }}</p>
            </div>
        @endforeach
    </div>
</section>
@endsection

