<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $dailySales = Order::whereDate('created_at', today())->sum('total_price');
        $monthlySales = Order::whereMonth('created_at', now()->month)->sum('total_price');
        $yearlySales = Order::whereYear('created_at', now()->year)->sum('total_price');

        $bestSellingProduct = Product::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->first();

        $topCustomer = User::withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->first();

        $orders = Order::all();
        $news = News::all();
        $products = Product::all();

        return view('admin.dashboard', compact('dailySales', 'monthlySales', 'yearlySales', 'bestSellingProduct', 'topCustomer', 'orders', 'news', 'products'));
    }
}