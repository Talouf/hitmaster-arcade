<!-- resources/views/news/show.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $newsItem->title }}</h1>
    <img src="{{ $newsItem->image_url }}" alt="{{ $newsItem->title }}" class="w-full h-64 object-cover">
    <div class="p-4">
        <p>{{ $newsItem->content }}</p>
    </div>
</div>
@endsection
