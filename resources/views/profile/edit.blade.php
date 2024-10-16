@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-4xl font-bold text-center mb-8 text-white">Profil Utilisateur</h1>
    @if (session('status'))
        <div class="bg-green-500 text-white p-4 rounded mb-4 text-center">
            {{ session('status') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-500 text-white p-4 rounded mb-4 text-center">
            {{ session('error') }}
        </div>
    @endif

    <!-- Tabs -->
    <div class="tabs flex justify-center mb-8">
        <button class="tab-button bg-red-500 text-white px-4 py-2 rounded mr-2"
            onclick="showTab('profile')">Profile</button>
        <button class="tab-button bg-red-500 text-white px-4 py-2 rounded mr-2"
            onclick="showTab('shipping')">Informations de livraison</button>
        <button class="tab-button bg-red-500 text-white px-4 py-2 rounded" onclick="showTab('orders')">Mes
            Commandes</button>
    </div>

    <!-- Profile Tab -->
    <div id="profile" class="tab-content">
        <form action="{{ route('profile.update') }}" method="POST" class="max-w-lg mx-auto p-8 rounded shadow-lg bg-gray-800">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label for="name" class="block text-white font-semibold">Nom de famille</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                    class="w-full p-2 border border-gray-600 rounded bg-gray-700 text-white">
                @error('name')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="surname" class="block text-white font-semibold">Prénom</label>
                <input type="text" name="surname" id="surname" value="{{ old('surname', $user->surname) }}"
                    class="w-full p-2 border border-gray-600 rounded bg-gray-700 text-white">
                @error('surname')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-white font-semibold">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                    class="w-full p-2 border border-gray-600 rounded bg-gray-700 text-white">
                @error('email')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="old_password" class="block text-white font-semibold">Ancien mot de passe</label>
                <input type="password" name="old_password" id="old_password"
                    class="w-full p-2 border border-gray-600 rounded bg-gray-700 text-white">
                @error('old_password')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-white font-semibold">Nouveau mot de passe</label>
                <input type="password" name="password" id="password" class="w-full p-2 border border-gray-600 rounded bg-gray-700 text-white">
                @error('password')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-white font-semibold">Confirmez le nouveau mot de
                    passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="w-full p-2 border border-gray-600 rounded bg-gray-700 text-white">
            </div>

            <div class="mb-4 text-center">
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Mettre à jour</button>
            </div>
        </form>
        <div class="mt-8 max-w-lg mx-auto p-8 rounded shadow-lg bg-gray-800">
            <h3 class="text-2xl font-bold text-center mb-4 text-white">Abonnement à la Newsletter</h3>
            <p class="text-white mb-4">
                Statut actuel:
                <span class="font-bold">
                    @if(Auth::user()->newsletterSubscription && Auth::user()->newsletterSubscription->is_active)
                        Abonné
                    @else
                        Non abonné
                    @endif
                </span>
            </p>
            <form action="{{ route('newsletter.toggle') }}" method="POST" class="text-center">
                @csrf
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    @if(Auth::user()->newsletterSubscription && Auth::user()->newsletterSubscription->is_active)
                        Se désabonner
                    @else
                        S'abonner
                    @endif
                </button>
            </form>
        </div>
    </div>

    <!-- Shipping Information Tab -->
    <div id="shipping" class="tab-content" style="display: none;">
        <h2 class="text-2xl font-bold text-center mb-8 text-white">Informations de livraison</h2>
        @if($shippingInfos && count($shippingInfos) > 0)
            <table class="min-w-full rounded shadow-lg text-center bg-gray-800">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="py-2 px-4 text-white">#</th>
                        <th class="py-2 px-4 text-white">Adresse</th>
                        <th class="py-2 px-4 text-white">Commune/Province</th>
                        <th class="py-2 px-4 text-white">Ville</th>
                        <th class="py-2 px-4 text-white">Code Postal</th>
                        <th class="py-2 px-4 text-white">Pays</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shippingInfos as $index => $shippingInfo)
                        <tr class="border-b border-gray-700">
                            <td class="py-2 px-4 text-white">{{ $index + 1 }}</td>
                            <td class="py-2 px-4 text-white">{{ $shippingInfo->address }}</td>
                            <td class="py-2 px-4 text-white">{{ $shippingInfo->city }}</td>
                            <td class="py-2 px-4 text-white">{{ $shippingInfo->state }}</td>
                            <td class="py-2 px-4 text-white">{{ $shippingInfo->zip_code }}</td>
                            <td class="py-2 px-4 text-white">{{ $shippingInfo->country }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center text-white">Aucun moyen de livraison indiqué</p>
        @endif
        <div class="text-center mt-4">
            <a href="{{ route('profile.add-shipping-info') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ajouter un
                moyen de livraison</a>
        </div>
    </div>

    <!-- Orders Tab -->
    <div id="orders" class="tab-content" style="display: none;">
        <h2 class="text-2xl font-bold text-center mb-8 text-white">Mes Commandes</h2>
        @if($orders && count($orders) > 0)
            <table class="min-w-full rounded shadow-lg text-center bg-gray-800">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="py-2 px-4 text-white">Numéro de commande</th>
                        <th class="py-2 px-4 text-white">Date</th>
                        <th class="py-2 px-4 text-white">Total</th>
                        <th class="py-2 px-4 text-white">Statut</th>
                        <th class="py-2 px-4 text-white">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr class="border-b border-gray-700">
                            <td class="py-2 px-4 text-white">{{ $order->id }}</td>
                            <td class="py-2 px-4 text-white">{{ $order->created_at->format('d/m/Y') }}</td>
                            <td class="py-2 px-4 text-white">{{ number_format($order->total_price, 2) }} €</td>
                            <td class="py-2 px-4 text-white">{{ ucfirst($order->status) }}</td>
                            <td class="py-2 px-4 text-white">
                                <a href="{{ route('orders.show', $order->id) }}"
                                    class="bg-blue-500 text-white px-2 py-1 rounded mr-2 hover:bg-blue-600">Détails</a>
                                <a href="{{ route('orders.invoice', $order->id) }}"
                                    class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">Facture</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center text-white">Vous n'avez pas encore passé de commande.</p>
        @endif
    </div>
</div>

<script>
    function showTab(tabName) {
        var i;
        var x = document.getElementsByClassName("tab-content");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        document.getElementById(tabName).style.display = "block";
    }
</script>
@endsection