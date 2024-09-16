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
            Log::error('Error during payment: ' . $e->getMessage());
            return redirect()->route('checkout.cancel')->with('error', 'An error occurred during payment.');
        }
    }

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

            $customer_email = $session->customer_details->email;
            $shipping = $session->shipping_details;

            Log::info('Shipping details: ' . json_encode($shipping));

            $existingUser = User::where('email', $customer_email)->first();

            if ($existingUser && (!Auth::check() || Auth::user()->email !== $customer_email)) {
                return redirect()->route('checkout.error')->with('error', 'A user with this email already exists. Please log in and try again.');
            }

            $order = $this->placeOrder($session);

            if ($shipping && $shipping->address) {
                $this->saveShippingInfo($order, $shipping);
            } else {
                Log::error('Error processing order: Shipping address is null');
                return redirect()->route('checkout.failed')->with('error', 'An error occurred while processing your order.');
            }

            $this->createPayment($order, $session);

            if ($existingUser && !$order->user_id) {
                $order->update(['user_id' => $existingUser->id]);
            }

            return view('checkout.success');
        } catch (\Exception $e) {
            Log::error('Error processing order: ' . $e->getMessage());
            return redirect()->route('checkout.failed')->with('error', 'An error occurred while processing your order.');
        }
    }

    private function placeOrder($session)
    {
        $order = Order::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'email' => $session->customer_details->email,
            'order_date' => now(),
            'total_price' => $session->amount_total / 100,
            'status' => 'paid'
        ]);

        Log::info('Order created', ['order_id' => $order->id]);

        $orderItems = OrderItem::where('user_id', Auth::id() ?? Session::get('cart_id'))
            ->where('is_ordered', false)
            ->get();

        foreach ($orderItems as $item) {
            $item->update(['is_ordered' => true, 'order_id' => $order->id]);
            Log::info('Order item updated', ['order_item_id' => $item->id, 'order_id' => $order->id]);
            
            $product = Product::find($item->product_id);
            $product->decrement('stock_quantity', $item->quantity);
        }

        return $order;
    }

    private function saveShippingInfo($order, $shipping)
    {
        $shippingInfo = new ShippingInfo();
        $shippingInfo->order_id = $order->id;
        $shippingInfo->address = $shipping->address->line1;
        $shippingInfo->city = $shipping->address->city;
        $shippingInfo->state = $shipping->address->state;
        $shippingInfo->zip_code = $shipping->address->postal_code;
        $shippingInfo->country = $shipping->address->country;
        $shippingInfo->save();
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
        return view('checkout.cancel');
    }

    public function error()
    {
        return view('checkout.error')->with('error', session('error'));
    }

// Method to update the status of an order
public function updateOrderStatus($orderId, $status)
{
    $order = Order::findOrFail($orderId);
    $order->status = $status;
    $order->save();

    return redirect()->route('orders.show', $orderId)->with('success', 'Order status updated.');
}

// Method for users to view their orders
public function userOrders()
{
    $userId = auth()->user()->id;
    $orders = Order::where('user_id', $userId)->get();

    return view('orders.index', compact('orders'));
}

// Method for users to view the details of a specific order
public function showOrder($id)
{
    $order = Order::with('orderItems')->findOrFail($id);

    return view('orders.show', compact('order'));
}
}