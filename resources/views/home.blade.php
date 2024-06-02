@php
    use Illuminate\Support\Str;
@endphp
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <section class="text-center mb-8">
        <h2 class="text-3xl font-bold">Derniers Produits</h2>
        <p>Améliorez votre confort de jeu avec nos nouvelles box</p>
        <button class="btn btn-primary">Explorer</button>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-8">
            <div class="card">
                <img src="{{ asset('images/black_controller.webp') }}" alt="HitMaster α" class="mb-2">
                <p>HitMaster α - 100€</p>
            </div>
            <div class="card">
                <img src="{{ asset('images/white_controller.webp') }}" alt="HitMaster β" class="mb-2">
                <p>HitMaster β - 120€</p>
            </div>
        </div>
    </section>

    <section class="text-center mb-8">
        <h2 class="text-3xl font-bold">Dernières News</h2>
        <div class="flex justify-center mt-4 space-x-4">
            @foreach ($latestNews as $newsItem)
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

    <section class="text-center mb-8">
        <h2 class="text-3xl font-bold">Avis de nos clients</h2>
        <div class="flex justify-center mt-4 space-x-4">
            <div class="testimonial">
                <p>"Je suis devenu trop fort depuis que j'ai une HitMaster α!"</p>
                <p>Jean-Édgar<br>Joueur occasionnel</p>
            </div>
            <div class="testimonial">
                <p>"Mes combos sortent tout seuls"</p>
                <p>Anne-Marie<br>Débutante</p>
            </div>
            <div class="testimonial">
                <p>"J'ai pas perdu un seul tournoi depuis que j'ai la HitMaster β"</p>
                <p>StreetGod<br>Joueur professionnel</p>
            </div>
        </div>
    </section>
</div>
@endsection




