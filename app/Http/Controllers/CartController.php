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
        $userId = Auth::check() ? Auth::id() : Session::get('cart_id');
        $cartItems = OrderItem::where('user_id', $userId)->where('is_ordered', false)->get();
        $totalProducts = $cartItems->sum('quantity');

        return view('cart.show', compact('cartItems', 'totalProducts'));
    }

    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
    
        if ($product->stock_quantity < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Product is out of stock',
            ], 400);
        }

        $userId = Auth::check() ? Auth::id() : (Session::get('cart_id') ?? Session::put('cart_id', uniqid()));
    
        $orderItem = OrderItem::where('user_id', $userId)
            ->where('product_id', $productId)
            ->where('is_ordered', false)
            ->first();
    
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
    
        $product->decrement('stock_quantity');

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
            'message' => 'Added to cart successfully',
            'cartCount' => $cartCount,
            'totalProducts' => $totalProducts,
            'cartItems' => $cartItems,
        ]);
    }

    public function linkCartToUser()
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $tempCartId = Session::get('cart_id');

            OrderItem::where('user_id', $tempCartId)->update(['user_id' => $userId]);

            Session::forget('cart_id');
        }
    }

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

    public function getCartCount()
    {
        $userId = Auth::check() ? Auth::id() : Session::get('cart_id');

        $cartCount = OrderItem::where('user_id', $userId)
            ->where('is_ordered', false)
            ->sum('quantity');

        return response()->json(['success' => true, 'cartCount' => $cartCount]);
    }
}