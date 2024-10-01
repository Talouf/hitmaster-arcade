@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Mes Commandes</h1>

    @if($orders->isEmpty())
        <p>Vous n'avez pas encore passé de commande.</p>
    @else
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Numéro de commande</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($orders as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($order->total_price, 2) }} €</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($order->status) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-900">Voir détails</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection