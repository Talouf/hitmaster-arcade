@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <h1 class="text-4xl font-bold text-white mb-8">Créer une actualité</h1>

    <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="bg-gray-800 p-6 rounded-lg shadow-md">
        @csrf
        <div class="mb-6">
            <label for="title" class="block text-gray-300 text-lg font-bold mb-2">Titre</label>
            <input type="text" name="title" id="title" class="w-full bg-gray-700 text-white border border-gray-600 rounded py-2 px-3 focus:outline-none focus:border-indigo-500" required>
        </div>

        <div class="mb-6">
            <label for="content" class="block text-gray-300 text-lg font-bold mb-2">Contenu</label>
            <textarea name="content" id="content" class="w-full bg-gray-700 text-white border border-gray-600 rounded py-2 px-3 focus:outline-none focus:border-indigo-500" rows="4" required></textarea>
        </div>

        <div class="mb-6">
            <label for="image" class="block text-gray-300 text-lg font-bold mb-2">Image</label>
            <input type="file" name="image" id="image" class="w-full bg-gray-700 text-white border border-gray-600 rounded py-2 px-3 focus:outline-none focus:border-indigo-500">
        </div>

        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline">Créer</button>
    </form>
</div>
@endsection