@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Send Newsletter</h2>
    <form action="{{ route('admin.sendNewsletter') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="subject">Subject</label>
            <input type="text" class="form-control" id="subject" name="subject" required>
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea class="form-control" id="content" name="content" rows="10" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send Newsletter</button>
    </form>
</div>
@endsection