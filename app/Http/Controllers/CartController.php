<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;

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

        OrderItem::updateOrCreate(
            [
                'user_id' => $userId,
                'product_id' => $product->id,
                'is_ordered' => false,
            ],
            [
                'quantity' => DB::raw('quantity + 1'),
                'price' => $product->price,
            ]
        );

        return response()->json(['success' => true, 'message' => 'Added to cart successfully']);
    }

    public function showCart()
    {
        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            $userId = Session::get('cart_id');
        }

        $cartItems = OrderItem::where('user_id', $userId)->where('is_ordered', false)->get();
        return view('cart.show', compact('cartItems'));
    }
}


