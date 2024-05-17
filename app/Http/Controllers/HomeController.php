<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class HomeController extends Controller
{
    public function index()
    {
        // Récupérer les 3 dernières news
        $latestNews = News::orderBy('created_at', 'desc')->take(3)->get();

        // Passer les données à la vue
        return view('home', compact('latestNews'));
    }
}

