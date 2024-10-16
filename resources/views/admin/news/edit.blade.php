@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-white">Edit News</h1>
    <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data" class="bg-gray-800 p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="title" class="block text-gray-300 text-sm font-bold mb-2">Title</label>
            <input type="text" name="title" id="title" value="{{ $news->title }}" class="w-full bg-gray-700 text-white border border-gray-600 rounded py-2 px-3 focus:outline-none focus:border-indigo-500">
        </div>
        <div class="mb-4">
            <label for="content" class="block text-gray-300 text-sm font-bold mb-2">Content</label>
            <textarea name="content" id="content" rows="5" class="w-full bg-gray-700 text-white border border-gray-600 rounded py-2 px-3 focus:outline-none focus:border-indigo-500">{{ $news->content }}</textarea>
        </div>
        <div class="mb-4">
            <label for="image" class="block text-gray-300 text-sm font-bold mb-2">Image</label>
            <input type="file" name="image" id="image" class="w-full bg-gray-700 text-white border border-gray-600 rounded py-2 px-3 focus:outline-none focus:border-indigo-500">
        </div>
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update News</button>
    </form>
</div>
@endsection