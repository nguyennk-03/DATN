<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        // Eager load the user and product relationships
        $reviews = Review::with(['user', 'product'])->get();
        return response()->json($reviews);
    }

    public function store(StoreReviewRequest $request)
    {
        // Validation is handled by StoreReviewRequest
        $review = Review::create($request->validated());
        return response()->json($review, 201);
    }

    public function show($id)
    {
        $review = Review::with(['user', 'product'])->findOrFail($id);
        return response()->json($review);
    }

    public function update(StoreReviewRequest $request, $id)
    {
        $review = Review::findOrFail($id);

        // Check if the logged-in user is the owner of the review
        if ($review->user_id !== Auth::id()) {
            return response()->json(['message' => 'You do not have permission to update this review'], 403);
        }

        $review->update($request->validated());
        return response()->json($review);
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        // Check if the logged-in user is the owner of the review
        if ($review->user_id !== Auth::id()) {
            return response()->json(['message' => 'You do not have permission to delete this review'], 403);
        }

        $review->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}