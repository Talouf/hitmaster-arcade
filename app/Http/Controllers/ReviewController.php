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
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|between:1,5',
            'content' => 'required|string',
        ]);

        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $productId = $request->input('product_id');

        // Check if the user has purchased the product
        $hasOrdered = Order::where('user_id', $user->id)
            ->whereHas('orderItems', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->exists();

        if (!$hasOrdered) {
            return response()->json(['error' => 'You must purchase this product before leaving a review.'], 403);
        }

        // Check if the user has already left a review
        $hasReviewed = Review::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->exists();

        if ($hasReviewed) {
            return response()->json(['error' => 'You have already reviewed this product.'], 403);
        }

        // Create the review
        $review = new Review($request->all());
        $review->user_id = $user->id;
        $review->save();

        return response()->json([
            'success' => true,
            'message' => 'Review added successfully',
            'data' => $review
        ], 201);
    }
}