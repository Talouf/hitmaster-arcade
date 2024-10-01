<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Order;

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

        // Check if cart_id exists in session, otherwise create a new one
        if (!Session::has('cart_id')) {
            Session::put('cart_id', uniqid()); // Generate a unique session-based cart ID
        }
        $cartId = Session::get('cart_id');

        // Check if the product already exists in the cart
        $orderItem = OrderItem::where('order_id', $cartId)
            ->where('product_id', $productId)
            ->where('is_ordered', false)
            ->first();

        if ($orderItem) {
            $orderItem->quantity += 1; // Increment the quantity if the product is already in the cart
            $orderItem->save();
        } else {
            // Create a new OrderItem for the product
            OrderItem::create([
                'order_id' => $cartId,
                'product_id' => $productId,
                'quantity' => 1,
                'price' => $product->price,
                'is_ordered' => false,  // Product is not yet part of a completed order
            ]);
        }

        // Count the total quantity of items in the cart
        $cartCount = OrderItem::where('order_id', $cartId)
            ->where('is_ordered', false)
            ->sum('quantity');

        $cartItems = OrderItem::where('order_id', $cartId)
            ->where('is_ordered', false)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Added to cart successfully',
            'cartCount' => $cartCount,
            'cartItems' => $cartItems,
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
}
