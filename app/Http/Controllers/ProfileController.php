<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ShippingInfoRequest;
use App\Models\ShippingInfo;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\User;


class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $shippingInfos = $user->shippingInfos;
        $orders = $user->orders()->latest()->get();  // Add this line

        return view('profile.edit', compact('user', 'shippingInfos', 'orders'));
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Associate any existing guest orders with the new user account
        Order::where('guest_email', $request->email)
            ->update([
                'user_id' => $user->id,
                'guest_email' => null
            ]);

        Auth::login($user);

        return redirect()->route('profile.edit')->with('status', 'Account created successfully.');
    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'old_password' => 'nullable|required_with:password|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->email = $request->email;

        if ($request->filled('password')) {
            if (!Hash::check($request->old_password, $user->password)) {
                return back()->withErrors(['old_password' => 'The provided password does not match our records.']);
            }
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('status', 'Profile updated successfully.');
    }

    public function addShippingInfo(): View
    {
        return view('profile.add-shipping-info');
    }

    public function storeShippingInfo(ShippingInfoRequest $request): RedirectResponse
    {
        $user = Auth::user();
        if ($user->shippingInfos()->count() >= 3) {
            return redirect()->route('profile.edit')->with('error', 'You can only have up to 3 shipping addresses.');
        }

        $shippingInfo = new ShippingInfo($request->validated());
        $shippingInfo->user_id = $user->id;
        $shippingInfo->save();

        return redirect()->route('profile.edit')->with('status', 'Shipping info added.');
    }
}
