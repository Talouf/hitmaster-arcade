<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nickname' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'nickname' => $request->nickname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Link existing orders to the newly created user
        Order::where('guest_email', $user->email)
            ->whereNull('user_id')
            ->update([
                'user_id' => $user->id,
                'guest_email' => null
            ]);

        // Link existing newsletter subscription
        $user->linkNewsletterSubscription();

        return redirect(route('profile.edit', absolute: false));
    }
}