@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Create News</h1>
    <form action="{{ route('admin.news.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="block font-bold">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="content" class="block font-bold">Content</label>
            <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="post_date" class="block font-bold">Post Date</label>
            <input type="date" class="form-control" id="post_date" name="post_date" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
    </form>
</div>
@endsection
