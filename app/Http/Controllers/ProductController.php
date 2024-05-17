<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);
        return view('products', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('product', compact('product'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'like', "%$query%")
            ->orWhere('description', 'like', "%$query%")
            ->orWhere('details', 'like', "%$query%")
            ->paginate(10);

        return view('products', compact('products'));
    }
}
