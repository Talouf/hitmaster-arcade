<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        return app(AdminDashboardController::class)->index();
    }

    // News management methods (unchanged)
    public function createNews()
    {
        return view('admin.news.create');
    }

    public function storeNews(Request $request)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_fr' => 'required|string|max:255',
            'content_en' => 'required',
            'content_fr' => 'required',
            'post_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $news = new News($request->except('image'));
        $news->admin_id = Auth::id();

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $news->image = 'images/' . $imageName;
        }

        $news->save(); // Add this line to save the news item

        return redirect()->route('admin.dashboard')->with('success', 'News created successfully.');
    }


    public function deleteNews($id)
    {
        $news = News::findOrFail($id);
        $news->delete();

        return redirect()->route('admin.dashboard')->with('success', 'News deleted successfully.');
    }

    // Product management
    public function createProduct()
    {
        return view('admin.products.create');
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'details' => 'nullable|string',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'details' => $request->details,
            'price' => $request->price,
            'image' => 'images/' . $imageName,
            'stock_quantity' => $request->stock_quantity,
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }
    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Product deleted successfully.');
    }

    public function editNews($id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.edit', compact('news'));
    }

    public function updateNews(Request $request, $id)
    {
        $news = News::findOrFail($id);

        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_fr' => 'required|string|max:255',
            'content_en' => 'required',
            'content_fr' => 'required',
            'post_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $news->fill($request->except('image'));

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $news->image = 'images/' . $imageName;
        }

        $news->save();  // Add this line to save the changes

        return redirect()->route('admin.dashboard')->with('success', 'News updated successfully.');
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'details' => 'nullable|string',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $product->fill($request->except('image'));

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $product->image = 'images/' . $imageName;
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    // New methods for order management
    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->route('admin.dashboard')->with('success', 'Order status updated successfully.');
    }

    public function showOrder($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }
}