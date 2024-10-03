@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <h1 class="text-4xl font-bold text-white mb-8">Créer une actualité</h1>

    <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="bg-dark-blue p-6 rounded-lg shadow-md">
        @csrf
        <div class="mb-6">
            <label for="title" class="block text-white text-lg font-bold mb-2">Titre</label>
            <input type="text" name="title" id="title" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" required>
        </div>

        <div class="mb-6">
            <label for="content" class="block text-white text-lg font-bold mb-2">Contenu</label>
            <textarea name="content" id="content" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" rows="4" required></textarea>
        </div>

        <div class="mb-6">
            <label for="image" class="block text-white text-lg font-bold mb-2">Image</label>
            <input type="file" name="image" id="image" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
        </div>

        <button type="submit" class="bg-red-500 text-white font-bold py-2 px-6 rounded-lg hover:bg-red-600 transition-colors">Créer</button>
    </form>
</div>
@endsection
