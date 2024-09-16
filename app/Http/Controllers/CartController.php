<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Order;
use App\Models\Order;

class CartController extends Controller
{
    public function showCart()
    {
        $userId = Auth::check() ? Auth::id() : Session::get('cart_id');
        $cartItems = OrderItem::where('user_id', $userId)->where('is_ordered', false)->get();

        // Assure-toi de calculer le nombre total de produits
        $totalProducts = $cartItems->sum('quantity');


        return view('cart.show', compact('cartItems', 'totalProducts'));
    }

    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
    
        // Determine user ID or session-based cart ID
        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            if (!Session::has('cart_id')) {
                Session::put('cart_id', uniqid());
            }
            $userId = Session::get('cart_id');
        }
    
        // Check if the product is already in the cart
        $orderItem = OrderItem::where('user_id', $userId)
            ->where('product_id', $productId)
            ->where('is_ordered', false)
            ->first();
    
        // Update quantity if exists, otherwise create a new item
        if ($orderItem) {
            $orderItem->quantity += 1;
            $orderItem->save();
        } else {
            OrderItem::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => 1,
                'price' => $product->price,
                'is_ordered' => false,
            ]);
        }
    
        $cartCount = OrderItem::where('user_id', $userId)
            ->where('is_ordered', false)
            ->sum('quantity');
    
        // Correct use of totalProducts
        $totalProducts = OrderItem::where('user_id', $userId)
            ->where('is_ordered', false)
            ->sum('quantity');  // Total number of products
    
        $cartItems = OrderItem::where('user_id', $userId)
            ->where('is_ordered', false)
            ->get();
    
        // Return totalProducts in the response
        return response()->json([
            'success' => true,
            'message' => 'Added to cart successfully',
            'cartCount' => $cartCount,
            'totalProducts' => $totalProducts,  // Add this line to return the total products count
            'cartItems' => $cartItems,
        ]);
    }
    

    // Link temporary cart to authenticated user
    public function linkCartToUser()
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $tempCartId = Session::get('cart_id');

            // Update the orders linked to the temporary session cart ID
            OrderItem::where('user_id', $tempCartId)->update(['user_id' => $userId]);

            // Optionally, remove the cart_id from the session
            Session::forget('cart_id');
        }
    }

    // Reintroduced removeFromCart method
    public function removeFromCart(Request $request, $productId)
    {
        $quantityToRemove = $request->input('quantity', 1);

        $userId = Auth::check() ? Auth::id() : Session::get('cart_id');

        $orderItem = OrderItem::where('user_id', $userId)
            ->where('product_id', $productId)
            ->where('is_ordered', false)
            ->first();

        if ($orderItem) {
            if ($orderItem->quantity > $quantityToRemove) {
                $orderItem->quantity -= $quantityToRemove;
                $orderItem->save();
            } else {
                $orderItem->delete();
            }

            $product = Product::find($productId);
            $product->increment('stock_quantity', $quantityToRemove);
        }

        $remainingQuantity = $orderItem ? $orderItem->quantity : 0;
        $cartCount = OrderItem::where('user_id', $userId)
            ->where('is_ordered', false)
            ->sum('quantity');
        $totalProducts = OrderItem::where('user_id', $userId)
            ->where('is_ordered', false)
            ->sum('quantity');
        $cartItems = OrderItem::where('user_id', $userId)
            ->where('is_ordered', false)
            ->get();

        return response()->json([
            'success' => true,
            'remainingQuantity' => $remainingQuantity,
            'cartCount' => $cartCount,
            'totalProducts' => $totalProducts,
            'cartItems' => $cartItems
        ]);
    }

    // Reintroduced getCartCount method
    public function getCartCount()
    {
        $userId = Auth::check() ? Auth::id() : Session::get('cart_id');

        $cartCount = OrderItem::where('user_id', $userId)
            ->where('is_ordered', false)
            ->sum('quantity');

        return response()->json(['success' => true, 'cartCount' => $cartCount]);
    }
}