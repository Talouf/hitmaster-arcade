<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShippingInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $userId = Auth::check() ? Auth::id() : Session::get('cart_id');
        $cartItems = OrderItem::where('user_id', $userId)->where('is_ordered', false)->get();

        $lineItems = $cartItems->map(function ($item) {
            return [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item->product->name,
                    ],
                    'unit_amount' => $item->price * 100,
                ],
                'quantity' => $item->quantity,
            ];
        })->toArray();

        Log::info('Line items: ' . json_encode($lineItems));

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', ['session_id' => '{CHECKOUT_SESSION_ID}']),
            'cancel_url' => route('checkout.cancel'),
        ]);

        Log::info('Created Stripe session ID: ' . $session->id);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $sessionId = $request->query('session_id');
        Log::info('Retrieved session ID from query: ' . $sessionId);

        try {
            $session = StripeSession::retrieve($sessionId);
        } catch (\Exception $e) {
            Log::error('Error retrieving Stripe session: ' . $e->getMessage());
            return redirect()->route('checkout.failed')->with('error', 'Unable to retrieve session.');
        }

        $customer_email = $session->customer_details->email;
        $cartId = Session::get('cart_id');

        $order = Order::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'email' => $customer_email,
            'order_date' => now(),
            'total_price' => $session->amount_total / 100,
        ]);

        foreach (OrderItem::where('user_id', Auth::id() ?? $cartId)->where('is_ordered', false)->get() as $item) {
            $item->update(['is_ordered' => true, 'order_id' => $order->id]);
        }

        ShippingInfo::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'order_id' => $order->id,
            'email' => $customer_email,
            'address' => $session->shipping->address->line1,
            'city' => $session->shipping->address->city,
            'state' => $session->shipping->address->state,
            'zip_code' => $session->shipping->address->postal_code,
            'country' => $session->shipping->address->country,
        ]);

        return view('checkout.success');
    }

    public function cancel()
    {
        return view('checkout.cancel');
    }
}
