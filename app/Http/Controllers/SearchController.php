<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\News;
use Illuminate\Support\Facades\App;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $locale = App::getLocale();
        
        $products = Product::where('name', 'like', "%$query%")
            ->orWhere('description', 'like', "%$query%")
            ->orWhere('details', 'like', "%$query%")
            ->get();

        $news = News::where("title_{$locale}", 'like', "%$query%")
            ->orWhere("content_{$locale}", 'like', "%$query%")
            ->get();

        return view('search_results', compact('products', 'news', 'query'));
    }
}
