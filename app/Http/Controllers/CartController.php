<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
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

        return response()->json(['success' => true, 'message' => 'Added to cart successfully']);
    }

    public function showCart()
    {
        $userId = Auth::check() ? Auth::id() : Session::get('cart_id');
        $cartItems = OrderItem::where('user_id', $userId)->where('is_ordered', false)->get();
        return view('cart.show', compact('cartItems'));
    }
}
