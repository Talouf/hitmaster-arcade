<?php

// CartController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\OrderItem;

class CartController extends Controller
{
    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $cartItem = OrderItem::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'product_id' => $productId,
                'is_ordered' => false
            ],
            [
                'quantity' => $request->input('quantity', 1),
                'price' => $product->price
            ]
        );

        return response()->json(['success' => true, 'message' => 'Product added to cart']);
    }

    public function showCart()
    {
        $cartItems = OrderItem::where('user_id', auth()->id())->where('is_ordered', false)->get();
        return view('cart.show', compact('cartItems'));
    }
}


