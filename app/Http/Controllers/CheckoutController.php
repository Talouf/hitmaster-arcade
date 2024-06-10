<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShippingInfo;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        try {
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

            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.cancel'),
            ]);

            return view('checkout.index', [
                'cartItems' => $cartItems,
                'sessionId' => $session->id
            ]);
        } catch (\Exception $e) {
            Log::error('Error during checkout: ' . $e->getMessage());
            return redirect()->route('checkout.cancel')->with('error', 'An error occurred during checkout.');
        }
    }


    public function success(Request $request)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $sessionId = $request->query('session_id');
            Log::info('Retrieved session ID from query: ' . $sessionId);

            if (!$sessionId) {
                throw new \Exception('Session ID missing in the request.');
            }

            $session = StripeSession::retrieve($sessionId);

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

            return view('checkout.success');
        } catch (\Exception $e) {
            Log::error('Error during success handling: ' . $e->getMessage());
            return redirect()->route('checkout.failed')->with('error', 'An error occurred while processing your order.');
        }
    }

    public function cancel()
    {
        return view('checkout.cancel');
    }
}
