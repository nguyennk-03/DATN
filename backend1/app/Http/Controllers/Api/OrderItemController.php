<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrderItemController extends Controller
{
    use AuthorizesRequests;

    // Lấy danh sách sản phẩm trong một đơn hàng
    public function index($orderId)
    {
        $order = Order::findOrFail($orderId);

        // Kiểm tra quyền truy cập
        $this->authorize('view', $order);

        $orderItems = $order->items; // Quan hệ items() trong model Order
        return response()->json($orderItems);
    }

    // Thêm sản phẩm vào đơn hàng
    public function store(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        $this->authorize('update', $order); // Kiểm tra quyền của người dùng

        $validated = $request->validate([
            'product_variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        // Kiểm tra xem sản phẩm variant có tồn tại
        $productVariant = ProductVariant::findOrFail($validated['product_variant_id']);

        // Thêm sản phẩm vào đơn hàng
        $orderItem = OrderItem::create([
            'order_id' => $order->id,
            'product_variant_id' => $productVariant->id,
            'quantity' => $validated['quantity'],
            'price' => $validated['price'],
        ]);

        return response()->json($orderItem, 201);
    }

    // Cập nhật sản phẩm trong đơn hàng
    public function update(Request $request, $orderId, $itemId)
    {
        $order = Order::findOrFail($orderId);
        $this->authorize('update', $order); // Kiểm tra quyền của người dùng

        $orderItem = OrderItem::findOrFail($itemId);

        // Kiểm tra quyền sửa đơn hàng sản phẩm này
        if ($orderItem->order_id != $order->id) {
            return response()->json(['message' => 'Sản phẩm không thuộc đơn hàng này.'], 400);
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        // Cập nhật thông tin sản phẩm trong đơn hàng
        $orderItem->quantity = $validated['quantity'];
        $orderItem->price = $validated['price'];
        $orderItem->save();

        return response()->json($orderItem);
    }

    // Xóa sản phẩm khỏi đơn hàng
    public function destroy($orderId, $itemId)
    {
        $order = Order::findOrFail($orderId);
        $this->authorize('update', $order); // Kiểm tra quyền của người dùng

        $orderItem = OrderItem::findOrFail($itemId);

        // Kiểm tra quyền xóa sản phẩm trong đơn hàng
        if ($orderItem->order_id != $order->id) {
            return response()->json(['message' => 'Sản phẩm không thuộc đơn hàng này.'], 400);
        }

        $orderItem->delete();
        return response()->json(['message' => 'Sản phẩm đã được xóa khỏi đơn hàng.']);
    }
}