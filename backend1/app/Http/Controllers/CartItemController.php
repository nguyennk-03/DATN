<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Http\Requests\StoreCartItemRequest;
use App\Http\Resources\CartItemResource;

class CartItemController extends Controller
{
    // Get all cart items
    public function index()
    {
        $cartItems = CartItem::paginate(10); // Adding pagination to handle large datasets
        return CartItemResource::collection($cartItems);
    }

    // Add a new cart item
    public function store(StoreCartItemRequest $request)
    {
        // Validation is handled by StoreCartItemRequest
        $validated = $request->validated();

        // Create a new cart item
        $cartItem = CartItem::create($validated);
        
        return new CartItemResource($cartItem);
    }

    // Get a single cart item
    public function show($id)
    {
        $cartItem = CartItem::findOrFail($id);
        return new CartItemResource($cartItem);
    }

    // Delete a cart item
    public function destroy($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();
        
        return response()->json(['message' => 'Cart item deleted successfully']);
    }
}
