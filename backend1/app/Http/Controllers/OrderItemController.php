<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Http\Resources\OrderItemResource;

class OrderItemController extends Controller
{
    // Get a list of order items
    public function index()
    {
        $orderItems = OrderItem::with('product_variant')->paginate(10);
        return OrderItemResource::collection($orderItems);
    }

    // Store a new order item
    public function store(Request $request)
    {
        // Validation could be added here
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        // Create new OrderItem
        $orderItem = OrderItem::create($validated);
        return new OrderItemResource($orderItem);
    }

    // Get a specific order item by ID
    public function show($id)
    {
        $orderItem = OrderItem::with('product_variant')->findOrFail($id);
        return new OrderItemResource($orderItem);
    }

    // Update an existing order item
    public function update(Request $request, $id)
    {
        $orderItem = OrderItem::findOrFail($id);

        // Validation
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        // Update the order item
        $orderItem->update($validated);
        return new OrderItemResource($orderItem);
    }

    // Delete an order item
    public function destroy($id)
    {
        $orderItem = OrderItem::findOrFail($id);
        $orderItem->delete();
        return response()->json(['message' => 'Order item deleted successfully.']);
    }
}
