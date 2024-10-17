@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 text-white">
    <h1 class="text-3xl font-bold mb-8 text-center">Dashboard Admin</h1>

    <div class="mb-8">
        <h2 class="text-2xl font-semibold mb-4">Toutes les Commandes</h2>
        <div class="overflow-x-auto bg-gray-800 rounded-lg shadow">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="py-3 px-4 bg-gray-700 text-left text-xs font-medium uppercase tracking-wider">ID</th>
                        <th class="py-3 px-4 bg-gray-700 text-left text-xs font-medium uppercase tracking-wider">Utilisateur</th>
                        <th class="py-3 px-4 bg-gray-700 text-left text-xs font-medium uppercase tracking-wider">Date</th>
                        <th class="py-3 px-4 bg-gray-700 text-left text-xs font-medium uppercase tracking-wider">Prix</th>
                        <th class="py-3 px-4 bg-gray-700 text-left text-xs font-medium uppercase tracking-wider">Statut</th>
                        <th class="py-3 px-4 bg-gray-700 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800">
                    @foreach($orders as $order)
                        <tr class="border-b border-gray-700">
                            <td class="py-4 px-4 whitespace-nowrap">{{ $order->id }}</td>
                            <td class="py-4 px-4 whitespace-nowrap">{{ $order->user_id }}</td>
                            <td class="py-4 px-4 whitespace-nowrap">{{ $order->order_date }}</td>
                            <td class="py-4 px-4 whitespace-nowrap">{{ $order->total_price }}</td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" onchange="this.form.submit()" class="bg-gray-700 text-white rounded px-2 py-1">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded text-sm">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mb-8">
        <h2 class="text-2xl font-semibold mb-4">Toutes les News</h2>
        <a href="{{ route('admin.news.create') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded mb-4">Créer News</a>
        <div class="overflow-x-auto bg-gray-800 rounded-lg shadow">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="py-3 px-4 bg-gray-700 text-left text-xs font-medium uppercase tracking-wider">ID</th>
                        <th class="py-3 px-4 bg-gray-700 text-left text-xs font-medium uppercase tracking-wider">Titres</th>
                        <th class="py-3 px-4 bg-gray-700 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800">
    @foreach($news as $newsItem)
        <tr class="border-b border-gray-700">
            <td class="py-4 px-4 whitespace-nowrap">{{ $newsItem->id }}</td>
            <td class="py-4 px-4">
                EN: {{ $newsItem->title_en }}<br>
                FR: {{ $newsItem->title_fr }}
            </td>
            <td class="py-4 px-4 whitespace-nowrap">
                <a href="{{ route('admin.news.edit', $newsItem->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded text-sm mr-2">Edit</a>
                <form action="{{ route('admin.news.delete', $newsItem->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded text-sm">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
</tbody>
            </table>
        </div>
    </div>

    <div class="mb-8">
        <h2 class="text-2xl font-semibold mb-4">Tous les produits</h2>
        <a href="{{ route('admin.products.create') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded mb-4">Ajouter un produit</a>
        <div class="overflow-x-auto bg-gray-800 rounded-lg shadow">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="py-3 px-4 bg-gray-700 text-left text-xs font-medium uppercase tracking-wider">ID</th>
                        <th class="py-3 px-4 bg-gray-700 text-left text-xs font-medium uppercase tracking-wider">Nom</th>
                        <th class="py-3 px-4 bg-gray-700 text-left text-xs font-medium uppercase tracking-wider">Prix</th>
                        <th class="py-3 px-4 bg-gray-700 text-left text-xs font-medium uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800">
                    @foreach($products as $product)
                        <tr class="border-b border-gray-700">
                            <td class="py-4 px-4 whitespace-nowrap">{{ $product->id }}</td>
                            <td class="py-4 px-4">{{ $product->name }}</td>
                            <td class="py-4 px-4 whitespace-nowrap">{{ $product->price }}</td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded text-sm mr-2">Edit</a>
                                <form action="{{ route('admin.products.delete', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded text-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
        <div class="bg-gray-800 rounded-lg p-4 shadow">
            <h5 class="font-bold text-xl mb-2">Ventes Journalières</h5>
            <p class="text-3xl">${{number_format($dailySales, 2) }}</p>
        </div>
        <div class="bg-gray-800 rounded-lg p-4 shadow">
            <h5 class="font-bold text-xl mb-2">Ventes Mensuelles</h5>
            <p class="text-3xl">${{ number_format($monthlySales, 2) }}</p>
        </div>
        <div class="bg-gray-800 rounded-lg p-4 shadow">
            <h5 class="font-bold text-xl mb-2">Ventes Annuelles</h5>
            <p class="text-3xl">${{ number_format($yearlySales, 2) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
        <div class="bg-gray-800 rounded-lg p-4 shadow">
            <h5 class="font-bold text-xl mb-2">Best Seller</h5>
            @if($bestSellingProduct)
                <p>{{ $bestSellingProduct->name }} ({{ $bestSellingProduct->order_items_count }} vendus)</p>
            @else
                <p>Pas de données</p>
            @endif
        </div>
        <div class="bg-gray-800 rounded-lg p-4 shadow">
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