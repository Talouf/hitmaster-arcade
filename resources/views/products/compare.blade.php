@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Comparaison de Produits</h1>
    <div class="overflow-x-auto">
        <table class="w-full table-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2">Caractéristique</th>
                    @foreach ($products as $product)
                        <th class="px-4 py-2">{{ $product->name }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border px-4 py-2 font-semibold">Prix</td>
                    @foreach ($products as $product)
                        <td class="border px-4 py-2">{{ $product->price }}€</td>
                    @endforeach
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-semibold">Description</td>
                    @foreach ($products as $product)
                        <td class="border px-4 py-2">{{ $product->description }}</td>
                    @endforeach
                </tr>
                <!-- Add more rows for other product features -->
            </tbody>
        </table>
    </div>
</div>
@endsection