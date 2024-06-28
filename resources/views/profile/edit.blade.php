@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-4xl font-bold text-center mb-8">Edit Profile</h1>
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
        <button class="tab-button bg-red-500 text-white px-4 py-2 rounded" onclick="showTab('shipping')">Shipping
            Information</button>
    </div>

    <!-- Profile Tab -->
    <div id="profile" class="tab-content">
        <form action="{{ route('profile.update') }}" method="POST" class="max-w-lg mx-auto p-8 rounded shadow-lg">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label for="name" class="block text-white font-semibold">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                    class="w-full p-2 border border-gray-300 rounded">
                @error('name')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="surname" class="block text-white font-semibold">Surname</label>
                <input type="text" name="surname" id="surname" value="{{ old('surname', $user->surname) }}"
                    class="w-full p-2 border border-gray-300 rounded">
                @error('surname')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-white font-semibold">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                    class="w-full p-2 border border-gray-300 rounded">
                @error('email')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="old_password" class="block text-white font-semibold">Old Password</label>
                <input type="password" name="old_password" id="old_password"
                    class="w-full p-2 border border-gray-300 rounded">
                @error('old_password')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-white font-semibold">New Password</label>
                <input type="password" name="password" id="password" class="w-full p-2 border border-gray-300 rounded">
                @error('password')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-white font-semibold">Confirm New Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="w-full p-2 border border-gray-300 rounded">
            </div>

            <div class="mb-4 text-center">
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Update Profile</button>
            </div>
        </form>
    </div>

    <!-- Shipping Information Tab -->
    <div id="shipping" class="tab-content" style="display: none;">
        <h2 class="text-2xl font-bold text-center mb-8">Shipping Information</h2>
        @if($shippingInfos && count($shippingInfos) > 0)
            <table class="min-w-full rounded shadow-lg text-center">
                <thead>
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
            <p class="text-center text-white">No shipping information available.</p>
        @endif
        <div class="text-center mt-4">
            <a href="{{ route('profile.add-shipping-info') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add Shipping Address</a>
        </div>
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