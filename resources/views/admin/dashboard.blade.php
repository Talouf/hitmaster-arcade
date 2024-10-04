@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold my-4 text-center">Dashboard Admin</h1>

    <div class="mb-8">
        <h2 class="text-2xl font-semibold my-4">Toutes les Commandes</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4 border-b text-center">ID Commande</th>
                        <th class="py-2 px-4 border-b text-center">ID Utilisateur</th>
                        <th class="py-2 px-4 border-b text-center">Date de commande</th>
                        <th class="py-2 px-4 border-b text-center">Prix Total</th>
                        <th class="py-2 px-4 border-b text-center">Statut</th>
                        <th class="py-2 px-4 border-b text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="hover:bg-gray-600">
                            <td class="py-2 px-4 border-b text-center">{{ $order->id }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $order->user_id }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $order->order_date }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $order->total_price }}</td>
                            <td class="py-2 px-4 border-b text-center">
                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" onchange="this.form.submit()"
                                        class="bg-gray-700 text-white rounded">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                            Processing</option>
                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped
                                        </option>
                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>
                                            Delivered</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                            Cancelled</option>
                                    </select>
                                </form>
                            </td>
                            <td class="py-2 px-4 border-b text-center">
                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                    class="bg-blue-500 text-white py-1 px-3 rounded">View Details</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mb-8">
        <h2 class="text-2xl font-semibold my-4">Toutes les News</h2>
        <a href="{{ route('admin.news.create') }}"
            class="btn btn-primary my-4 bg-blue-500 text-white py-2 px-4 rounded">Créer News</a>
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4 border-b text-center">News ID</th>
                        <th class="py-2 px-4 border-b text-center">Titres</th>
                        <th class="py-2 px-4 border-b text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($news as $newsItem)
                        <tr class="hover:bg-gray-600">
                            <td class="py-2 px-4 border-b text-center">{{ $newsItem->id }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $newsItem->title }}</td>
                            <td class="py-2 px-4 border-b text-center">
                                <a href="{{ route('admin.news.edit', $newsItem->id) }}"
                                    class="bg-blue-500 text-white py-1 px-3 rounded mr-2">Edit</a>
                                <form action="{{ route('admin.news.delete', $newsItem->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Are you sure you want to delete this news item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white py-1 px-3 rounded">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mb-8">
        <h2 class="text-2xl font-semibold my-4">Tous les produits</h2>
        <a href="{{ route('admin.products.create') }}"
            class="btn btn-primary my-4 bg-blue-500 text-white py-2 px-4 rounded">Ajouter un produit</a>
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4 border-b text-center">ID de Produit</th>
                        <th class="py-2 px-4 border-b text-center">Nom</th>
                        <th class="py-2 px-4 border-b text-center">Prix</th>
                        <th class="py-2 px-4 border-b text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr class="hover:bg-gray-600">
                            <td class="py-2 px-4 border-b text-center">{{ $product->id }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $product->name }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $product->price }}</td>
                            <td class="py-2 px-4 border-b text-center">
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                    class="bg-blue-500 text-white py-1 px-3 rounded mr-2">Edit</a>
                                <form action="{{ route('admin.products.delete', $product->id) }}" method="POST"
                                    class="inline"
                                    onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white py-1 px-3 rounded">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bshadow rounded-lg p-4">
            <h5 class="font-bold text-xl mb-2">Ventes Journalièress</h5>
            <p class="text-3xl">${{number_format($dailySales, 2) }}</p>
        </div>
        <div class="shadow rounded-lg p-4">
            <h5 class="font-bold text-xl mb-2">Ventes Mensuelles</h5>
            <p class="text-3xl">${{ number_format($monthlySales, 2) }}</p>
        </div>
        <div class="shadow rounded-lg p-4">
            <h5 class="font-bold text-xl mb-2">Ventes Annuelles</h5>
            <p class="text-3xl">${{ number_format($yearlySales, 2) }}</p>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
        <div class="shadow rounded-lg p-4">
            <h5 class="font-bold text-xl mb-2">Best Seller</h5>
            @if($bestSellingProduct)
                <p>{{ $bestSellingProduct->name }} ({{ $bestSellingProduct->order_items_count }} vendus)</p>
            @else
                <p>Pas de données</p>
            @endif
        </div>
        <div class="shadow rounded-lg p-4">
            <h5 class="font-bold text-xl mb-2">Meilleur Client</h5>
            @if($topCustomer)
                <p>{{ $topCustomer->name }} ({{ $topCustomer->orders_count }} commandes)</p>
            @else
                <p>Pas de données</p>
            @endif
        </div>
    </div>
</div>
@endsection