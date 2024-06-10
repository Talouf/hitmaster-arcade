@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-4xl font-bold text-center mb-8">Edit Profile</h1>
    @if (session('status'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('status') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Tabs -->
    <div class="tabs">
        <button class="tab-button" onclick="showTab('profile')">Profile</button>
        <button class="tab-button" onclick="showTab('shipping')">Shipping Information</button>
    </div>

    <!-- Profile Tab -->
    <div id="profile" class="tab-content">
        <form action="{{ route('profile.update') }}" method="POST" class="max-w-lg mx-auto">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                    class="w-full p-2 border border-gray-300 rounded">
                @error('name')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="surname" class="block text-gray-700">Surname</label>
                <input type="text" name="surname" id="surname" value="{{ old('surname', $user->surname) }}"
                    class="w-full p-2 border border-gray-300 rounded">
                @error('surname')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                    class="w-full p-2 border border-gray-300 rounded">
                @error('email')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="old_password" class="block text-gray-700">Old Password</label>
                <input type="password" name="old_password" id="old_password"
                    class="w-full p-2 border border-gray-300 rounded">
                @error('old_password')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700">New Password</label>
                <input type="password" name="password" id="password" class="w-full p-2 border border-gray-300 rounded">
                @error('password')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700">Confirm New Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="w-full p-2 border border-gray-300 rounded">
            </div>

            <div class="mb-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Profile</button>
            </div>
        </form>
    </div>

    <!-- Shipping Information Tab -->
    <div id="shipping" class="tab-content" style="display: none;">
        <h2 class="text-2xl font-bold text-center mb-8">Shipping Information</h2>
        @if($shippingInfos && count($shippingInfos) > 0)
            <ul>
                @foreach ($shippingInfos as $shippingInfo)
                    <li>{{ $shippingInfo->address }}, {{ $shippingInfo->city }}, {{ $shippingInfo->state }}, {{ $shippingInfo->zip_code }}, {{ $shippingInfo->country }}</li>
                @endforeach
            </ul>
        @else
            <p>No shipping information available.</p>
        @endif
        <a href="{{ route('profile.add-shipping-info') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add Shipping Address</a>
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