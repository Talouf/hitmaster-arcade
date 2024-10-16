@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-white">Détails de la commande #{{ $order->id }}</h1>

    <div class="bg-gray-800 shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-white">Informations de la commande</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-400">Détails et articles de la commande.</p>
        </div>
        <div class="border-t border-gray-700">
            <dl>
                <div class="bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-400">Client</dt>
                    <dd class="mt-1 text-sm text-white sm:mt-0 sm:col-span-2">
                        {{ $order->user ? $order->user->name : 'Client invité' }}
                        ({{ $order->user ? $order->user->email : $order->guest_email }})
                    </dd>
                </div>
                <div class="bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-400">Date de commande</dt>
                    <dd class="mt-1 text-sm text-white sm:mt-0 sm:col-span-2">{{ $order->order_date->format('d/m/Y H:i') }}</dd>
                </div>
                <div class="bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-400">Statut</dt>
                    <dd class="mt-1 text-sm text-white sm:mt-0 sm:col-span-2">{{ ucfirst($order->status) }}</dd>
                </div>
                <div class="bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-400">Total</dt>
                    <dd class="mt-1 text-sm text-white sm:mt-0 sm:col-span-2">{{ number_format($order->total_price, 2) }} €</dd>
                </div>
            </dl>
        </div>
    </div>

    <h2 class="text-2xl font-bold mt-8 mb-4 text-white">Articles commandés</h2>
    <table class="min-w-full divide-y divide-gray-700">
        <thead class="bg-gray-800">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Produit</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Quantité</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Prix unitaire</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Total</th>
            </tr>
        </thead>
        <tbody class="bg-gray-700 divide-y divide-gray-600">
            @foreach ($order->orderItems as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-white">{{ $item->product->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-white">{{ $item->quantity }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-white">{{ number_format($item->price, 2) }} €</td>
                    <td class="px-6 py-4 whitespace-nowrap text-white">{{ number_format($item->quantity * $item->price, 2) }} €</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-8">
        <a href="{{ route('admin.dashboard') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Retour à la liste des commandes
        </a>
    </div>
</div>
@endsection