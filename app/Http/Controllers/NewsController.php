<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->paginate(10);
        foreach ($news as $newsItem) {
            Log::info('News item: ' . $newsItem->id . ', Image path: ' . $newsItem->image . ', Image URL: ' . $newsItem->image_url);
        }
        return view('news.index', compact('news'));
    }

    public function show($id)
    {
        $newsItem = News::findOrFail($id);

        $previousNews = News::where('post_date', '<', $newsItem->post_date)
            ->orderBy('post_date', 'desc')
            ->first();

        $nextNews = News::where('post_date', '>', $newsItem->post_date)
            ->orderBy('post_date', 'asc')
            ->first();

        $relatedNews = News::where('id', '!=', $newsItem->id)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('news.show', compact('newsItem', 'previousNews', 'nextNews', 'relatedNews'));
    }

    public function create()
    {
        return view('news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_fr' => 'required|string|max:255',
            'content_en' => 'required',
            'content_fr' => 'required',
            'post_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $news = new News($request->all());

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news_images', 'public');
            $news->image = $imagePath;
        }

        $news->admin_id = auth()->id(); // Assuming you're using authentication
        $news->save();

        return redirect()->route('news.index')->with('success', 'News created successfully.');
    }

    public function edit($slug)
    {
        $newsItem = News::findBySlug($slug);
        return view('news.edit', compact('newsItem'));
    }

    public function update(Request $request, $slug)
    {
        $newsItem = News::findBySlug($slug);

        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_fr' => 'required|string|max:255',
            'content_en' => 'required',
            'content_fr' => 'required',
            'post_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $newsItem->fill($request->all());

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news_images', 'public');
            $newsItem->image = $imagePath;
        }

        $newsItem->save();

        return redirect()->route('news.show', $newsItem->slug)->with('success', 'News updated successfully.');
    }

    public function destroy($slug)
    {
        $newsItem = News::findBySlug($slug);
        $newsItem->delete();

        return redirect()->route('news.index')->with('success', 'News deleted successfully.');
    }
}