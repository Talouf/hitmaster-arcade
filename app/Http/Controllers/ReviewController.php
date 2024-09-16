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

        // Check if the user has purchased the product
        $hasOrdered = Order::where('user_id', $user->id)
            ->whereHas('orderItems', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->exists();

        if (!$hasOrdered) {
            return response()->json(['error' => 'Vous devez acheter ce produit avant de laisser un avis.'], 403);
        }

        // Check if the user has already left a review
        $hasReviewed = Review::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->exists();

        if ($hasReviewed) {
            return response()->json(['error' => 'Vous avez déjà laissé un avis sur ce produit.'], 403);
        }

        // Create the review
        $review = new Review($request->all());
        $review->user_id = $user->id;
        $review->save();

        return response()->json(['message' => 'Avis ajouté avec succès'], 200);
    }

    public function apiStore(Request $request)
    {
        return $this->store($request);
    }
}