<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $orders = Order::all();
        return view('admin.dashboard', compact('orders'));
    }

    public function createNews()
    {
        return view('admin.news.create');
    }

    public function storeNews(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = time().'.'.$request->image->extension();  
        $request->image->move(public_path('images'), $imageName);

        News::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imageName,
            'admin_id' => Auth::id(),
            'post_date' => now(),
        ]);

        return redirect()->route('news.index')->with('success', 'News created successfully.');
    }
}


