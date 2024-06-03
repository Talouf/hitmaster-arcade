<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'note' => 'required|integer|between:1,5',
            'content' => 'required|string|max:1000',
        ]);

        Review::create([
            'product_id' => $request->product_id,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Review added successfully');
    }
}

