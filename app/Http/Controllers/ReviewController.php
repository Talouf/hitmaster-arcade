<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Order;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'rating' => 'required|integer|between:1,5',
        'content' => 'required|string',
    ]);

    $user = auth()->user();
    $productId = $request->input('product_id');

    // Check if the user has ordered the product
    $hasOrdered = Order::where('user_id', $user->id)
        ->whereHas('orderItems', function ($query) use ($productId) {
            $query->where('product_id', $productId);
        })
        ->exists();

    if (!$hasOrdered) {
        return redirect()->route('product.show', $productId)->with('error', 'You can only review products you have ordered.');
    }

    // Check if the user has already reviewed the product
    $hasReviewed = Review::where('user_id', $user->id)
        ->where('product_id', $productId)
        ->exists();

    if ($hasReviewed) {
        return redirect()->route('product.show', $productId)->with('error', 'You have already reviewed this product.');
    }

    $review = new Review();
    $review->product_id = $productId;
    $review->user_id = $user->id;
    $review->rating = $request->input('rating');
    $review->content = $request->input('content');
    $review->save();

    return redirect()->route('product.show', $productId)->with('success', 'Review added successfully.');
}
}