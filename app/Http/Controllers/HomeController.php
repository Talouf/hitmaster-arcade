<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $latestNews = News::latest()->take(2)->get();
        $latestProducts = Product::latest()->take(2)->get();
        $reviews = Review::latest()->take(3)->get();

        return view('home', compact('latestNews', 'latestProducts', 'reviews'));
    }
}
?>
