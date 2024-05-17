<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\News;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $products = Product::where('name', 'like', "%$query%")
            ->orWhere('description', 'like', "%$query%")
            ->orWhere('details', 'like', "%$query%")
            ->get();

        $news = News::where('title', 'like', "%$query%")
            ->orWhere('content', 'like', "%$query%")
            ->get();

        return view('search_results', compact('products', 'news', 'query'));
    }
}
