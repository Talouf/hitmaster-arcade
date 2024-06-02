<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;


class PaymentController extends Controller
{
    public function checkout()
    {
        return view('checkout');
    }

    public function processCheckout(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $charge = Charge::create([
            'amount' => $request->amount * 100,
            'currency' => 'usd',
            'description' => 'Order Description',
            'source' => $request->stripeToken,
        ]);

        // Save order details in database
        $order = new Order();
        $order->user_id = Auth::id();
        $order->order_date = now();
        $order->total_price = $request->amount;
        $order->save();

        return redirect()->route('dashboard')->with('success', 'Payment successful!');
    }
}

