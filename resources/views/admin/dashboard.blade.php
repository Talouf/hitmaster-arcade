@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold my-4">Dashboard Admin</h1>

    <h2 class="text-2xl font-semibold my-4">Toutes les Commandes</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-2 px-4 border-b">ID Commande</th>
                    <th class="py-2 px-4 border-b">ID Utilisateur</th>
                    <th class="py-2 px-4 border-b">Date de commande</th>
                    <th class="py-2 px-4 border-b">Prix Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr class="hover:bg-gray-600">
                        <td class="py-2 px-4 border-b">{{ $order->id }}</td>
                        <td class="py-2 px-4 border-b">{{ $order->user_id }}</td>
                        <td class="py-2 px-4 border-b">{{ $order->order_date }}</td>
                        <td class="py-2 px-4 border-b">{{ $order->total_price }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <h2 class="text-2xl font-semibold my-4">Toutes les News</h2>
    <a href="{{ route('admin.news.create') }}"
        class="btn btn-primary my-4 bg-blue-500 text-white py-2 px-4 rounded">Crée News</a>
    <div class="overflow-x-auto">

        <table class="min-w-full border border-gray-200">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-2 px-4 border-b">News ID</th>
                    <th class="py-2 px-4 border-b">Titres</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($news as $newsItem)
                    <tr class="hover:bg-gray-600">
                        <td class="py-2 px-4 border-b">{{ $newsItem->id }}</td>
                        <td class="py-2 px-4 border-b">{{ $newsItem->title }}</td>
                        <td class="py-2 px-4 border-b">
                            <form action="{{ route('admin.news.delete', $newsItem->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white py-1 px-3 rounded">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <h2 class="text-2xl font-semibold my-4">Tout les produits</h2>
    <a href="{{ route('admin.products.create') }}"
        class="btn btn-primary my-4 bg-blue-500 text-white py-2 px-4 rounded">Ajouter un produit</a>

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-2 px-4 border-b">ID de Produit</th>
                    <th class="py-2 px-4 border-b">Nom</th>
                    <th class="py-2 px-4 border-b">Prix</th>
                    <th class="py-2 px-4 border-b">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr class="hover:bg-gray-600">
                        <td class="py-2 px-4 border-b">{{ $product->id }}</td>
                        <td class="py-2 px-4 border-b">{{ $product->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $product->price }}</td>
                        <td class="py-2 px-4 border-b">
                            <form action="{{ route('admin.products.delete', $product->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white py-1 px-3 rounded">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection