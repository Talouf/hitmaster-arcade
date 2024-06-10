<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ShippingInfoRequest;
use App\Models\ShippingInfo;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\User;


class ProfileController extends Controller
{
    public function edit(): View
    {
        $user = Auth::user();
        $shippingInfos = $user->shippingInfos; // Assuming the user has a relationship with ShippingInfo

        return view('profile.edit', compact('user', 'shippingInfos'));
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
