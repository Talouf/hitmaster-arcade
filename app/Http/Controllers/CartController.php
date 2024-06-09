<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Product;

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

        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            if (!Session::has('cart_id')) {
                Session::put('cart_id', uniqid());
            }
            $userId = Session::get('cart_id');
        }

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
            'cartItems' => $cartItems
        ]);
    }

    public function removeFromCart(Request $request, $productId)
    {
        $quantityToRemove = $request->input('quantity', 1);

        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            if (!Session::has('cart_id')) {
                Session::put('cart_id', uniqid());
            }
            $userId = Session::get('cart_id');
        }

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
        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            $userId = Session::get('cart_id');
        }

        $cartCount = OrderItem::where('user_id', $userId)
            ->where('is_ordered', false)
            ->sum('quantity');

        return response()->json(['success' => true, 'cartCount' => $cartCount]);
    }
}
