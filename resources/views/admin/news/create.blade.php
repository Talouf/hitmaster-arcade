@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <h1 class="text-4xl font-bold text-white mb-8">Create News</h1>

    <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="bg-gray-800 p-6 rounded-lg shadow-md">
        @csrf
        <div class="mb-6">
            <label for="title_en" class="block text-gray-300 text-lg font-bold mb-2">Title (English)</label>
            <input type="text" name="title_en" id="title_en" class="w-full bg-gray-700 text-white border border-gray-600 rounded py-2 px-3 focus:outline-none focus:border-indigo-500" required>
        </div>

        <div class="mb-6">
            <label for="title_fr" class="block text-gray-300 text-lg font-bold mb-2">Title (French)</label>
            <input type="text" name="title_fr" id="title_fr" class="w-full bg-gray-700 text-white border border-gray-600 rounded py-2 px-3 focus:outline-none focus:border-indigo-500" required>
        </div>

        <div class="mb-6">
            <label for="content_en" class="block text-gray-300 text-lg font-bold mb-2">Content (English)</label>
            <textarea name="content_en" id="content_en" rows="4" class="w-full bg-gray-700 text-white border border-gray-600 rounded py-2 px-3 focus:outline-none focus:border-indigo-500" required></textarea>
        </div>

        <div class="mb-6">
            <label for="content_fr" class="block text-gray-300 text-lg font-bold mb-2">Content (French)</label>
            <textarea name="content_fr" id="content_fr" rows="4" class="w-full bg-gray-700 text-white border border-gray-600 rounded py-2 px-3 focus:outline-none focus:border-indigo-500" required></textarea>
        </div>

        <div class="mb-6">
            <label for="post_date" class="block text-gray-300 text-lg font-bold mb-2">Post Date</label>
            <input type="datetime-local" name="post_date" id="post_date" class="w-full bg-gray-700 text-white border border-gray-600 rounded py-2 px-3 focus:outline-none focus:border-indigo-500" required>
        </div>

        <div class="mb-6">
            <label for="image" class="block text-gray-300 text-lg font-bold mb-2">Image</label>
            <input type="file" name="image" id="image" class="w-full bg-gray-700 text-white border border-gray-600 rounded py-2 px-3 focus:outline-none focus:border-indigo-500">
        </div>

        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline">Create News</button>
    </form>
</div>
@endsection