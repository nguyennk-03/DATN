<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'List of users']);
    }

    public function statistics()
    {
        return response()->json(['message' => 'Admin statistics data']);
    }

    public function reviews()
    {
        return response()->json(['message' => 'List of all reviews']);
    }

    public function deleteReview($id)
    {
        return response()->json(['message' => 'Review deleted']);
    }
}
