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
use App\Models\User;

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
                'customer_email' => $request->email,
                'shipping_address_collection' => [
                    'allowed_countries' => ['US', 'CA', 'GB', 'FR', 'DE', 'IT', 'ES', 'NL', 'BE', 'CH', 'AT', 'SE', 'DK', 'FI', 'NO', 'IE'],
                ],
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
            $shipping = $session->shipping_details;

            // Log the shipping details for debugging
            Log::info('Shipping details: ' . json_encode($shipping));

            // Check if a user with this email already exists
            $existingUser = User::where('email', $customer_email)->first();

            if ($existingUser) {
                // If the user is not logged in, redirect to a custom error page
                if (!Auth::check() || Auth::user()->email !== $customer_email) {
                    return redirect()->route('checkout.error')->with('error', 'User with this email already exists. Please log in and redo your order.');
                }
            }

            $cartId = Session::get('cart_id');

            $order = Order::create([
                'user_id' => Auth::check() ? Auth::id() : null,
                'email' => $customer_email,
                'order_date' => now(),
                'total_price' => $session->amount_total / 100,
            ]);

            // Log the order creation
            Log::info('Order created', ['order_id' => $order->id]);

            $orderItems = OrderItem::where('user_id', Auth::id() ?? $cartId)->where('is_ordered', false)->get();
            foreach ($orderItems as $item) {
                $item->update(['is_ordered' => true, 'order_id' => $order->id]);
                // Log each order item update
                Log::info('Order item updated', ['order_item_id' => $item->id, 'order_id' => $order->id]);
            }

            // Save shipping information linked to the order
            if ($shipping && $shipping->address) {
                $shippingInfo = new ShippingInfo();
                $shippingInfo->order_id = $order->id;
                $shippingInfo->address = $shipping->address->line1;
                $shippingInfo->city = $shipping->address->city;
                $shippingInfo->state = $shipping->address->state;
                $shippingInfo->zip_code = $shipping->address->postal_code;
                $shippingInfo->country = $shipping->address->country;
                $shippingInfo->save();
            } else {
                Log::error('Error during success handling: Shipping address is null');
                return redirect()->route('checkout.failed')->with('error', 'An error occurred while processing your order.');
            }

            // Link the order to the user if they create an account later
            if ($existingUser && !$order->user_id) {
                $order->update(['user_id' => $existingUser->id]);
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
    public function error()
    {
        return view('checkout.error')->with('error', session('error'));
    }
}
