<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Order;
use App\Models\User; // Import the User class
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;


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
        // Email removed based on professor's directive. // Save the email used in Stripe
        $order->save();

        return redirect()->route('dashboard')->with('success', 'Payment successful!');
    }



    // Method to update the status of a payment
    public function updatePaymentStatus($paymentId, $status)
    {
        $payment = Payment::findOrFail($paymentId);
        $payment->status = $status;
        $payment->save();

        return redirect()->route('payments.show', $paymentId)->with('success', 'Payment status updated.');
    }

    // Method for admin to view all payments
    public function index()
    {
        $payments = Payment::with('order')->get();

        return view('payments.index', compact('payments'));
    }

    // Method for admin to view a specific payment's details
    public function show($id)
    {
        $payment = Payment::with('order')->findOrFail($id);

        return view('payments.show', compact('payment'));
    }
}