<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;

class CartItemController extends Controller
{
    public function index()
    {
        return response()->json(CartItem::all());
    }

    public function store(Request $request)
    {
        $cartItem = CartItem::create($request->all());
        return response()->json($cartItem, 201);
    }

    public function show($id)
    {
        return response()->json(CartItem::findOrFail($id));
    }

    public function destroy($id)
    {
        CartItem::destroy($id);
        return response()->json(['message' => 'Deleted successfully']);
    }
}
