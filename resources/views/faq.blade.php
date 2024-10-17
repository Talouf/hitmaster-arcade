@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Foire Aux Questions</h1>
        @foreach($faqs as $faq)
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-2">{{ $faq['question'] }}</h2>
                <p>{{ $faq['answer'] }}</p>
            </div>
        @endforeach
    </div>
@endsection