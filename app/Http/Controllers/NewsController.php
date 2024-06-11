<?php

// app/Http/Controllers/NewsController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::all();
        return view('news.index', compact('news'));
    }

    public function create()
    {
        return view('news.create');
    }

    /* public function store(Request $request)
     {
         $request->validate([
             'title' => 'required|string|max:255',
             'content' => 'required',
             'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
         ]);

         $news = new News();
         $news->title = $request->title;
         $news->content = $request->content;
         $news->admin_id = auth()->user()->id; // Get the authenticated admin's ID
         $news->post_date = now();

         if ($request->hasFile('image')) {
             $imagePath = $request->file('image')->store('news_images', 'public');
             $news->image = $imagePath;
         }

         $news->save();

         return redirect()->route('news.index')->with('success', 'News created successfully.');
     } */

    public function show($id)
    {
        $newsItem = News::findOrFail($id);
        return view('news.show', compact('newsItem'));
    }
}

