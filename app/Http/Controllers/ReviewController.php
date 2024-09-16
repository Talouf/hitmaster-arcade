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

    // Vérifier si l'utilisateur a commandé le produit
    $hasOrdered = Order::where('user_id', $user->id)
        ->whereHas('orderItems', function ($query) use ($productId) {
            $query->where('product_id', $productId);
        })
        ->exists();

    if (!$hasOrdered) {
        return response()->json(['error' => 'Vous devez acheter ce produit avant de laisser un avis.'], 403);
    }

    // Vérifier si l'utilisateur a déjà laissé un avis
    $hasReviewed = Review::where('user_id', $user->id)
        ->where('product_id', $productId)
        ->exists();

    if ($hasReviewed) {
        return response()->json(['error' => 'Vous avez déjà laissé un avis sur ce produit.'], 403);
    }

    // Ajouter l'avis
    $review = new Review();
    $review->product_id = $productId;
    $review->user_id = $user->id;
    $review->rating = $request->input('rating');
    $review->content = $request->input('content');
    $review->save();

    return response()->json(['message' => 'Avis ajouté avec succès'], 200);
}

}