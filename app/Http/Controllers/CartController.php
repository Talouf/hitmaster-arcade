<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Order;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function showCart()
    {
        $cartId = Session::get('cart_id');  // Use session-based cart ID

        $cartItems = OrderItem::with('product') // Eager load product
            ->where('order_id', $cartId)
            ->where('is_ordered', false)
            ->get();

        $totalProducts = $cartItems->sum('quantity');

        return view('cart.show', compact('cartItems', 'totalProducts'));
    }


    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        if (!Session::has('cart_id')) {
            Session::put('cart_id', uniqid());
        }
        $cartId = Session::get('cart_id');

        $orderItem = OrderItem::where('order_id', $cartId)
            ->where('product_id', $productId)
            ->where('is_ordered', false)
            ->first();

        if ($orderItem) {
            $orderItem->quantity += 1;
            $orderItem->save();
        } else {
            OrderItem::create([
                'order_id' => $cartId,
                'product_id' => $productId,
                'quantity' => 1,
                'price' => $product->price,
                'is_ordered' => false,
            ]);
        }

        $cartItems = OrderItem::where('order_id', $cartId)
            ->where('is_ordered', false)
            ->get();

        $cartCount = $cartItems->sum('quantity');
        $cartTotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        return response()->json([
            'success' => true,
            'message' => 'Added to cart successfully',
            'cartCount' => $cartCount,
            'totalProducts' => $cartCount,
            'cartItems' => $cartItems,
            'cartTotal' => number_format($cartTotal, 2, '.', ''),
            'updatedQuantity' => $orderItem ? $orderItem->quantity : 1
        ]);
    }

    // Method to link temporary session cart to authenticated user
    public function linkCartToUser()
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $tempCartId = Session::get('cart_id');

            // Update the order items with the session cart ID to link them to the user
            OrderItem::where('order_id', $tempCartId)
                ->update(['order_id' => $userId]);

            // Optionally remove the cart_id from the session
            Session::forget('cart_id');
        }
    }

    public function removeFromCart(Request $request, $productId)
    {
        $quantityToRemove = $request->input('quantity', 1);
        $cartId = Session::get('cart_id');

        $orderItem = OrderItem::where('order_id', $cartId)
            ->where('product_id', $productId)
            ->where('is_ordered', false)
            ->first();

        $remainingQuantity = 0;

        if ($orderItem) {
            if ($orderItem->quantity > $quantityToRemove) {
                $orderItem->quantity -= $quantityToRemove;
                $orderItem->save();
                $remainingQuantity = $orderItem->quantity;
            } else {
                $orderItem->delete();
            }
        }

        $cartItems = OrderItem::where('order_id', $cartId)
            ->where('is_ordered', false)
            ->get();

        $cartCount = $cartItems->sum('quantity');
        $cartTotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        return response()->json([
            'success' => true,
            'remainingQuantity' => $remainingQuantity,
            'cartCount' => $cartCount,
            'totalProducts' => $cartCount,
            'cartItems' => $cartItems,
            'cartTotal' => $cartTotal
        ]);
    }

    // Method to get the current cart count
    public function getCartCount()
    {
        $cartId = Session::get('cart_id');

        $cartCount = OrderItem::where('order_id', $cartId)
            ->where('is_ordered', false)
            ->sum('quantity');

        return response()->json(['success' => true, 'cartCount' => $cartCount]);
    }
    public function initiateCheckout(Request $request)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $cartItems = $this->getCartItems();
            $lineItems = $this->prepareLineItems($cartItems);

            $user = Auth::user();

            $sessionParams = [
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.cancel'),
                'shipping_address_collection' => [
                    'allowed_countries' => ['US', 'CA', 'GB', 'FR', 'DE', 'IT', 'ES', 'NL', 'BE', 'CH', 'AT', 'SE', 'DK', 'FI', 'NO', 'IE'],
                ],
            ];

            if ($user) {
                $sessionParams['customer_email'] = $user->email;

                $shippingInfo = $user->shippingInfos->first();
                if ($shippingInfo) {
                    $sessionParams['shipping_options'] = [
                        [
                            'shipping_rate_data' => [
                                'type' => 'fixed_amount',
                                'fixed_amount' => [
                                    'amount' => 0,
                                    'currency' => 'usd',
                                ],
                                'display_name' => 'Free shipping',
                                'delivery_estimate' => [
                                    'minimum' => [
                                        'unit' => 'business_day',
                                        'value' => 5,
                                    ],
                                    'maximum' => [
                                        'unit' => 'business_day',
                                        'value' => 7,
                                    ],
                                ],
                            ],
                        ],
                    ];

                    // Convert country name to ISO 2-letter code if necessary
                    $countryCode = $this->getCountryCode($shippingInfo->country);
                    if ($countryCode && in_array($countryCode, $sessionParams['shipping_address_collection']['allowed_countries'])) {
                        $sessionParams['shipping_address_collection']['allowed_countries'] = [$countryCode];
                    }
                }
            }

            $session = StripeSession::create($sessionParams);

            return redirect($session->url);
        } catch (\Exception $e) {
            Log::error('Checkout error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred during checkout. Please try again.');
        }
    }
    private function getCountryCode($countryName)
    {
        $countries = [
            'United States' => 'US',
            'Canada' => 'CA',
            'United Kingdom' => 'GB',
            'France' => 'FR',
            'Germany' => 'DE',
            'Italy' => 'IT',
            'Spain' => 'ES',
            'Netherlands' => 'NL',
            'Belgium' => 'BE',
            'Switzerland' => 'CH',
            'Austria' => 'AT',
            'Sweden' => 'SE',
            'Denmark' => 'DK',
            'Finland' => 'FI',
            'Norway' => 'NO',
            'Ireland' => 'IE',
            // Add more countries as needed
        ];

        return $countries[ucwords(strtolower($countryName))] ?? null;
    }
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
}