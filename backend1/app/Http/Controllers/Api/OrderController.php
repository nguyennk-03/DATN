<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrderController extends Controller
{
    use AuthorizesRequests;

    // Lấy danh sách đơn hàng của người dùng
    public function index()
    {
        $user = Auth::user();
        $orders = $user->orders;  // Quan hệ orders() trong model User
        return response()->json($orders);
    }

    // Lấy chi tiết đơn hàng
    public function show($id)
    {
        $order = Order::findOrFail($id);
        $this->authorize('view', $order);  // Kiểm tra quyền của người dùng

        return response()->json($order);
    }

    // Tạo đơn hàng mới
    public function store(Request $request)
    {
        $user = Auth::user();

        // Lấy danh sách các sản phẩm trong giỏ hàng của người dùng
        $cartItems = CartItem::where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Giỏ hàng của bạn trống'], 400);
        }

        // Tính tổng giá trị đơn hàng
        $totalPrice = 0;
        foreach ($cartItems as $cartItem) {
            $productVariant = ProductVariant::findOrFail($cartItem->product_id);
            $totalPrice += $productVariant->price * $cartItem->quantity;
        }

        // Tạo đơn hàng
        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);

        // Thêm các sản phẩm vào đơn hàng
        foreach ($cartItems as $cartItem) {
            $productVariant = ProductVariant::findOrFail($cartItem->product_id);
            OrderItem::create([
                'order_id' => $order->id,
                'product_variant_id' => $productVariant->id,
                'quantity' => $cartItem->quantity,
                'price' => $productVariant->price,
            ]);
        }

        // Xóa các sản phẩm trong giỏ hàng của người dùng sau khi đặt hàng
        $cartItems->each->delete();

        return response()->json($order, 201);
    }

    // Cập nhật trạng thái đơn hàng
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $this->authorize('update', $order);  // Kiểm tra quyền của người dùng

        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,canceled',
        ]);

        $order->status = $validated['status'];
        $order->save();

        return response()->json($order);
    }

    // Cập nhật trạng thái thanh toán đơn hàng
    public function updatePaymentStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $this->authorize('update', $order);  // Kiểm tra quyền của người dùng

        $validated = $request->validate([
            'payment_status' => 'required|in:pending,paid,failed',
        ]);

        $order->payment_status = $validated['payment_status'];
        $order->save();

        return response()->json($order);
    }
}