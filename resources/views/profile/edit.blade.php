<!-- resources/views/profile/edit.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-4xl font-bold text-center mb-8">Edit Profile</h1>
    @if (session('status'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('status') }}
        </div>
    @endif
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

    <h2 class="text-2xl font-bold text-center mb-8">Shipping Information</h2>
    <form action="{{ route('profile.store-shipping-info') }}" method="POST" class="max-w-lg mx-auto">
        @csrf
        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $shippingInfo->email ?? '') }}"
                class="w-full p-2 border border-gray-300 rounded">
            @error('email')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="address" class="block text-gray-700">Address</label>
            <input type="text" name="address" id="address" value="{{ old('address', $shippingInfo->address ?? '') }}"
                class="w-full p-2 border border-gray-300 rounded">
            @error('address')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="city" class="block text-gray-700">City</label>
            <input type="text" name="city" id="city" value="{{ old('city', $shippingInfo->city ?? '') }}"
                class="w-full p-2 border border-gray-300 rounded">
            @error('city')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="state" class="block text-gray-700">State</label>
            <input type="text" name="state" id="state" value="{{ old('state', $shippingInfo->state ?? '') }}"
                class="w-full p-2 border border-gray-300 rounded">
            @error('state')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="zip_code" class="block text-gray-700">Zip Code</label>
            <input type="text" name="zip_code" id="zip_code"
                value="{{ old('zip_code', $shippingInfo->zip_code ?? '') }}"
                class="w-full p-2 border border-gray-300 rounded">
            @error('zip_code')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="country" class="block text-gray-700">Country</label>
            <input type="text" name="country" id="country" value="{{ old('country', $shippingInfo->country ?? '') }}"
                class="w-full p-2 border border-gray-300 rounded">
            @error('country')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Shipping Info</button>
        </div>
    </form>
</div>
@endsection