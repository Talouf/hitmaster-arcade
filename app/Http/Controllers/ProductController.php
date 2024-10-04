<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('stock_quantity', '>', 0)->get();
        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::with('reviews')->findOrFail($id);
        $inStock = $product->stock_quantity > 0;
        return view('products.show', compact('product', 'inStock'));
    }

    public function apiIndex()
    {
        $products = Product::all();
        return response()->json($products);
    }

    public function home()
    {
        $latestProducts = Product::latest()->take(2)->get();
        return view('home', compact('latestProducts'));
    }

    // Admin methods
    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => 'images/' . $imageName,
            'stock_quantity' => $request->stock_quantity,
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->except('image'));

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $product->image = 'images/' . $imageName;
            $product->save();
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete(); // This will now soft delete

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function compare(Request $request)
    {
        $productIds = $request->input('product', []);
        if (empty($productIds)) {
            return redirect()->route('products.index')->with('error', 'Please select at least one product to compare.');
        }
        $products = Product::whereIn('id', $productIds)->get();
        if ($products->isEmpty()) {
            return redirect()->route('products.index')->with('error', 'No valid products selected for comparison.');
        }
        return view('products.compare', compact('products'));
    }
}