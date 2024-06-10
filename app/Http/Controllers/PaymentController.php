<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Order;
use App\Models\User; // Import the User class
use Illuminate\Support\Facades\Auth;


class PaymentController extends Controller
{
    public function processCheckout(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            // Other validations
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $charge = Charge::create([
            'amount' => $request->amount * 100,
            'currency' => 'usd',
            'description' => 'Order Description',
            'source' => $request->stripeToken,
            'receipt_email' => $request->email,
        ]);

        // Check if the email is linked to an existing user
        $user = User::where('email', $request->email)->first();

        // Save order details in database
        $order = new Order();
        $order->user_id = $user ? $user->id : null; // Link to user if exists
        $order->order_date = now();
        $order->total_price = $request->amount;
        $order->email = $request->email; // Save the email used in Stripe
        $order->save();

        return redirect()->route('dashboard')->with('success', 'Payment successful!');
    }
}

