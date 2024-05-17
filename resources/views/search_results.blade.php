@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Résultats de recherche pour : "{{ $query }}"</h1>

        <h2>Produits</h2>
        <div class="row">
            @forelse($products as $product)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->description }}</p>
                            <p class="card-text"><strong>{{ $product->price }}€</strong></p>
                            <a href="{{ route('product.show', $product->id) }}" class="btn btn-primary">Voir le produit</a>
                        </div>
                    </div>
                </div>
            @empty
                <p>Aucun produit trouvé.</p>
            @endforelse
        </div>

        <h2>News</h2>
        <div class="row">
            @forelse($news as $newsItem)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">{{ $newsItem->title }}</h5>
                            <p class="card-text">{{ $newsItem->post_date }}</p>
                            <p class="card-text">{{ \Illuminate\Support\Str::limit($newsItem->content, 150) }}</p>
                            <a href="{{ route('news.show', $newsItem->id) }}" class="btn btn-primary">Lire la suite</a>
                        </div>
                    </div>
                </div>
            @empty
                <p>Aucune news trouvée.</p>
            @endforelse
        </div>
    </div>
@endsection
