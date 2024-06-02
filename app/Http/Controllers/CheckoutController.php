<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $cartItems = OrderItem::where('user_id', Auth::id())->where('is_ordered', false)->get();
        $totalAmount = $cartItems->sum('price');

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $paymentIntent = PaymentIntent::create([
            'amount' => $totalAmount * 100,
            'currency' => 'usd',
            'payment_method_types' => ['card'],
        ]);

        return view('checkout.index', [
            'clientSecret' => $paymentIntent->client_secret,
            'totalAmount' => $totalAmount,
        ]);
    }

    public function success()
    {
        // Logic for successful payment
        return view('checkout.success');
    }

    public function cancel()
    {
        // Logic for canceled payment
        return view('checkout.cancel');
    }
}
