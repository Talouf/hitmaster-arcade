@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold my-4">Order Details</h1>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Order #{{ $order->id }}
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Placed on {{ $order->order_date }}
            </p>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Customer
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $order->user ? $order->user->name : 'Guest' }}
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Total Price
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        ${{ $order->total_price }}
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Status
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ ucfirst($order->status) }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <h2 class="text-2xl font-bold mt-8 mb-4">Order Items</h2>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Product
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Quantity
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Price
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($order->orderItems as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $item->product->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $item->quantity }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        ${{ $item->price }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection