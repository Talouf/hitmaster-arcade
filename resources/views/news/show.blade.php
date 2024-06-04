<!-- resources/views/news/show.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ htmlspecialchars($newsItem->title) }}</h1>
    <img src="{{ htmlspecialchars($newsItem->image_url) }}" alt="{{ htmlspecialchars($newsItem->title) }}" class="w-full h-64 object-cover">
    <div class="p-4">
        <p>{{ htmlspecialchars($newsItem->content) }}</p>
    </div>
</div>
@endsection
