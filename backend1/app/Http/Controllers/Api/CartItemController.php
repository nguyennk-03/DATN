<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    // Lấy tất cả các mục trong giỏ hàng của người dùng
    public function index(Request $request)
    {
        $cartItems = CartItem::where('user_id', $request->user()->id)->get();
        return response()->json($cartItems);
    }

    // Tạo mới một mục giỏ hàng
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::create([
            'user_id' => $request->user()->id,
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity'],
        ]);

        return response()->json($cartItem, 201);
    }

    // Cập nhật mục giỏ hàng
    public function update(Request $request, $id)
    {
        $cartItem = CartItem::findOrFail($id);
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem->update($validated);
        return response()->json($cartItem);
    }

    // Xóa một mục giỏ hàng
    public function destroy($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();
        return response()->json(null, 204);
    }
}
