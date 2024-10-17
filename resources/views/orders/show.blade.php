@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-white">Détails de la commande #{{ $order->id }}</h1>

    <div class="bg-gray-800 shadow-lg rounded-lg overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-700">
            <h3 class="text-xl font-semibold text-white">Informations de la commande</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-2">Client</p>
                <p class="text-white">
                    {{ $order->user ? $order->user->name : 'Client invité' }}
                    <span class="text-gray-400">({{ $order->user ? $order->user->email : $order->guest_email }})</span>
                </p>
            </div>
            <div>
                <p class="text-gray-400 text-sm font-medium mb-2">Date de commande</p>
                <p class="text-white">{{ $order->order_date->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p class="text-gray-400 text-sm font-medium mb-2">Statut</p>
                <p class="text-white">{{ ucfirst($order->status) }}</p>
            </div>
            <div>
                <p class="text-gray-400 text-sm font-medium mb-2">Total</p>
                <p class="text-white font-bold">{{ number_format($order->total_price, 2) }} €</p>
            </div>
        </div>
    </div>

    <h2 class="text-2xl font-bold mb-4 text-white">Articles commandés</h2>
    <div class="bg-gray-800 shadow-lg rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-700">
            <thead class="bg-gray-900">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Produit</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Quantité</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Prix unitaire</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Total</th>
                </tr>
            </thead>
            <tbody class="bg-gray-800 divide-y divide-gray-700">
                @foreach ($order->orderItems as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-white">{{ $item->product->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-white">{{ $item->quantity }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-white">{{ number_format($item->price, 2) }} €</td>
                        <td class="px-6 py-4 whitespace-nowrap text-white font-medium">{{ number_format($item->quantity * $item->price, 2) }} €</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-8 flex justify-between items-center">
        <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
            Retour à la liste des commandes
        </a>
        <a href="{{ route('orders.invoice', $order->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
            Télécharger la facture
        </a>
    </div>
</div>
@endsection