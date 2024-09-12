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

        $hasPurchased = Order::where('user_id', $user->id)
            ->whereHas('orderItems', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->exists();

        if (!$hasPurchased) {
            return response()->json(['error' => 'You must purchase this product before leaving a review.'], 403);
        }

        $hasReviewed = Review::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->exists();

        if ($hasReviewed) {
            return response()->json(['error' => 'You have already reviewed this product.'], 403);
        }

        $review = new Review();
        $review->product_id = $productId;
        $review->user_id = $user->id;
        $review->rating = $request->input('rating');
        $review->content = $request->input('content');
        $review->save();

        return response()->json(['message' => 'Review added successfully'], 200);
    }
}