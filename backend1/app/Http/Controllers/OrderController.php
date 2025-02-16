<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items.product_variant'])->paginate(10);
        return OrderResource::collection($orders);
    }

    public function store(StoreOrderRequest $request)
    {
        // The validated data will be automatically passed from StoreOrderRequest
        $order = Order::create($request->validated());
        return response()->json(new OrderResource($order), 201);
    }

    public function show($id)
    {
        $order = Order::with(['user', 'items.product_variant'])->findOrFail($id);
        return new OrderResource($order);
    }

    public function update(StoreOrderRequest $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->validated());
        return response()->json(new OrderResource($order));
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found!'], 404);
        }

        $order->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
