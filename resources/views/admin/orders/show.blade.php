@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Détails de la commande #{{ $order->id }}</h1>

    <div class="bg-slate-300 shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Informations de la commande</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Détails et articles de la commande.</p>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-slate-400 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Client</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $order->user ? $order->user->name : 'Client invité' }}
                        ({{ $order->user ? $order->user->email : $order->guest_email }})
                    </dd>
                </div>
                <div class="bg-slate-400 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Date de commande</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $order->order_date->format('d/m/Y H:i') }}</dd>
                </div>
                <div class="bg-slate-400 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Statut</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ ucfirst($order->status) }}</dd>
                </div>
                <div class="bg-slate-400 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Total</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ number_format($order->total_price, 2) }} €</dd>
                </div>
            </dl>
        </div>
    </div>

    <h2 class="text-2xl font-bold mt-8 mb-4">Articles commandés</h2>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-slate-300">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix unitaire</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
            </tr>
        </thead>
        <tbody class="bg-slate-500 divide-y divide-gray-200">
            @foreach ($order->orderItems as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->product->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->quantity }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ number_format($item->price, 2) }} €</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ number_format($item->quantity * $item->price, 2) }} €</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-8">
        <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Retour à la liste des commandes
        </a>
    </div>
</div>
@endsection