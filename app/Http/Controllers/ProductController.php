<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\OrderItem;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);
        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'like', "%$query%")->paginate(10);
        return view('products.index', compact('products'));
    }

    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $userId = auth()->check() ? auth()->id() : null;

        OrderItem::updateOrCreate(
            ['user_id' => $userId, 'product_id' => $productId, 'is_ordered' => false],
            ['quantity' => 1, 'price' => $product->price]
        );

        return response()->json(['success' => true, 'message' => 'Product added to cart']);
    }

    public function showCart()
    {
        $userId = auth()->check() ? auth()->id() : null;
        $cartItems = OrderItem::where('user_id', $userId)->where('is_ordered', false)->get();

        return view('cart.show', compact('cartItems'));
    }
}
