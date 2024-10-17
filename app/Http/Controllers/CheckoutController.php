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
use App\Models\Product;
use App\Models\Payment;

class CheckoutController extends Controller
{
    private function getCartItems()
    {
        $cartId = Session::get('cart_id');
        return OrderItem::where('order_id', $cartId)
            ->where('is_ordered', false)
            ->get();
    }

    private function prepareLineItems($cartItems)
    {
        return $cartItems->map(function ($item) {
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
    }
    public function index()
    {
        $user = Auth::user();
        $cartItems = $this->getCartItems();
        $shippingAddresses = $user ? $user->shippingInfos : [];

        return view('checkout.index', compact('cartItems', 'shippingAddresses'));
    }
    public function processShipping(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip_code' => 'required|string',
            'country' => 'required|string',
        ]);

        $shippingInfo = new ShippingInfo($request->all());
        $shippingInfo->user_id = Auth::id();
        $shippingInfo->save();

        return $this->initiateStripeCheckout($shippingInfo->id);
    }

    private function initiateStripeCheckout($shippingInfoId = null)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $user = auth()->user();
        $cartItems = $this->getCartItems();
        $lineItems = $this->prepareLineItems($cartItems);

        $sessionParams = [
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel'),
        ];

        if ($user) {
            $sessionParams['customer_email'] = $user->email;

            $shippingAddresses = $user->shippingAddresses;
            if ($shippingAddresses->isNotEmpty()) {
                $sessionParams['shipping_address_collection'] = [
                    'allowed_countries' => ['US', 'CA', 'GB', 'FR', 'DE', 'IT', 'ES', 'NL', 'BE', 'CH', 'AT', 'SE', 'DK', 'FI', 'NO', 'IE'],
                ];

                // If a specific shipping address is selected
                if ($shippingInfoId) {
                    $selectedAddress = $shippingAddresses->find($shippingInfoId);
                    if ($selectedAddress) {
                        $sessionParams['shipping_options'] = [
                            [
                                'shipping_rate_data' => [
                                    'type' => 'fixed_amount',
                                    'fixed_amount' => ['amount' => 0, 'currency' => 'usd'],
                                    'display_name' => 'Free shipping',
                                    'delivery_estimate' => [
                                        'minimum' => ['unit' => 'business_day', 'value' => 5],
                                        'maximum' => ['unit' => 'business_day', 'value' => 7],
                                    ],
                                ],
                            ],
                        ];
                    }
                }
            }
        }

        $session = StripeSession::create($sessionParams);

        return redirect($session->url);
    }
    /*public function checkout(Request $request)
    {
        $user = Auth::user();
        $shippingAddresses = $user ? $user->shippingInfos : [];
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $cartId = Session::get('cart_id');
            $email = Auth::check() ? Auth::user()->email : $request->email;
            $cartItems = OrderItem::where('order_id', $cartId)
                ->where('is_ordered', false)
                ->get();

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
                'customer_email' => $email,
                'shipping_address_collection' => [
                    'allowed_countries' => ['US', 'CA', 'GB', 'FR', 'DE', 'IT', 'ES', 'NL', 'BE', 'CH', 'AT', 'SE', 'DK', 'FI', 'NO', 'IE'],
                ],
            ]);

            return view('checkout.index', [
                'cartItems' => $cartItems,
                'sessionId' => $session->id,
                'shippingAddresses' => $shippingAddresses
            ]);
        } catch (\Exception $e) {
            Log::error('Error during payment: ' . $e->getMessage());
            return redirect()->route('checkout.cancel')->with('error', 'An error occurred during payment.');
        }
    }*/


    public function success(Request $request)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $sessionId = $request->query('session_id');
            Log::info('Session ID retrieved from request: ' . $sessionId);

            if (!$sessionId) {
                throw new \Exception('Session ID is missing in the request.');
            }

            $session = StripeSession::retrieve($sessionId);

            Log::info('Full Stripe session details: ' . json_encode($session));

            $customer_email = $session->customer_details->email;
            $shipping = $session->shipping_details ?? $session->customer_details;

            Log::info('Shipping details: ' . json_encode($shipping));

            $user = Auth::user();

            $order = $this->placeOrder($session, $user);

            if ($shipping && $shipping->address) {
                $this->saveShippingInfo($order, $shipping);
            } else {
                Log::error('Error processing order: Shipping address is null');
                return redirect()->route('checkout.failed')->with('error', 'An error occurred while processing your order.');
            }

            $this->createPayment($order, $session);

            return view('checkout.success');
        } catch (\Exception $e) {
            Log::error('Error processing order: ' . $e->getMessage());
            return redirect()->route('checkout.failed')->with('error', 'An error occurred while processing your order.');
        }
    }
    private function placeOrder($session, $user = null)
    {
        $shippingDetails = $session->shipping_details ?? $session->customer_details;

        $order = Order::create([
            'user_id' => $user ? $user->id : null,
            'guest_email' => $user ? null : $session->customer_details->email,
            'order_date' => now(),
            'total_price' => $session->amount_total / 100,
            'status' => 'paid',
        ]);

        Log::info('Order created', ['order_id' => $order->id]);
        $shippingDetails = $session->shipping_details ?? $session->customer_details;
        if ($shippingDetails && $shippingDetails->address) {
            ShippingInfo::create([
                'order_id' => $order->id,
                'name' => $shippingDetails->name,
                'address' => $shippingDetails->address->line1,
                'city' => $shippingDetails->address->city,
                'state' => $shippingDetails->address->state,
                'zip_code' => $shippingDetails->address->postal_code,
                'country' => $shippingDetails->address->country,
            ]);
        }
        $cartId = Session::get('cart_id');
        $orderItems = OrderItem::where('order_id', $cartId)
            ->where('is_ordered', false)
            ->get();

        foreach ($orderItems as $item) {
            $item->update(['is_ordered' => true, 'order_id' => $order->id]);
            Log::info('Order item updated', ['order_item_id' => $item->id, 'order_id' => $order->id]);

            $product = Product::find($item->product_id);
            $product->decrement('stock_quantity', $item->quantity);
        }

        // Clear the cart
        Session::forget('cart_id');

        return $order;
    }
    private function saveShippingInfo($order, $shipping)
    {
        ShippingInfo::updateOrCreate(
            ['order_id' => $order->id],
            [
                'name' => $shipping->name,
                'address' => $shipping->address->line1,
                'city' => $shipping->address->city,
                'state' => $shipping->address->state,
                'zip_code' => $shipping->address->postal_code,
                'country' => $shipping->address->country,
                'user_id' => $order->user_id, // Assuming you want to associate with the user as well
            ]
        );
    }
    private function createPayment($order, $session)
    {
        Payment::create([
            'order_id' => $order->id,
            'amount' => $session->amount_total / 100,
            'payment_date' => now(),
            'payment_method' => 'stripe',
            'status' => 'completed'
        ]);
    }

    public function cancel()
    {
        return redirect()->route('cart.show')->with('error', 'Checkout was cancelled.');
    }

    public function error()
    {
        return view('checkout.error')->with('error', session('error'));
    }

    public function updateOrderStatus($orderId, $status)
    {
        $order = Order::findOrFail($orderId);
        $order->status = $status;
        $order->save();

        return redirect()->route('orders.show', $orderId)->with('success', 'Order status updated.');
    }

    public function userOrders()
    {
        $userId = auth()->user()->id;
        $orders = Order::where('user_id', $userId)->get();

        return view('orders.index', compact('orders'));
    }

    public function showOrder($id)
    {
        $order = Order::with('orderItems')->findOrFail($id);

        return view('orders.show', compact('order'));
    }

}