<?php

// app/Http/Controllers/NewsController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::all();
        return view('index', compact('news'));
    }

    public function show($id)
    {
        $newsItem = News::findOrFail($id);
        return view('news.show', compact('newsItem'));
    }
}

