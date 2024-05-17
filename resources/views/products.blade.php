@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('products.search') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="query" class="form-control" placeholder="Rechercher des produits...">
                <button type="submit" class="btn btn-primary">Rechercher</button>
            </div>
        </form>

        <div class="row">
            @foreach($products as $product)
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
            @endforeach
        </div>

        {{ $products->links() }}
    </div>
@endsection
