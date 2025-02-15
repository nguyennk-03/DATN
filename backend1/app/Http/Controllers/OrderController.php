<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    //  Xem danh sách đơn hàng của người dùng
    public function index()
    {
        $user = Auth::user();
        $orders = Order::with('orderItems.product')->where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        return response()->json(['orders' => $orders]);
    }

    //  Xem chi tiết một đơn hàng
    public function show($id)
    {
        $user = Auth::user();
        $order = Order::with('orderItems.product')->where('id', $id)->where('user_id', $user->id)->first();

        if (!$order) {
            return response()->json(['message' => 'Không tìm thấy đơn hàng!'], 404);
        }

        return response()->json(['order' => $order]);
    }

    //  Đặt hàng từ giỏ hàng
    public function store(Request $request)
    {
        $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Giỏ hàng của bạn đang trống!'], 400);
        }

        $totalPrice = 0;

        foreach ($cartItems as $cartItem) {
            $product = Product::find($cartItem->product_id);
            if (!$product || $cartItem->quantity > $product->stock) {
                return response()->json(['message' => "Sản phẩm '{$product->name}' không đủ hàng!"], 400);
            }
            $totalPrice += $product->price * $cartItem->quantity;
        }

        // Tạo đơn hàng
        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => $totalPrice,
            'status' => 'cho_xac_nhan',
            'payment_status' => 'cho_thanh_toan',
        ]);

        // Thêm sản phẩm vào order_items
        foreach ($cartItems as $cartItem) {
            $product = Product::find($cartItem->product_id);
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $product->price,
            ]);

            // Giảm số lượng tồn kho
            $product->stock -= $cartItem->quantity;
            $product->save();
        }

        // Xóa giỏ hàng sau khi đặt hàng
        CartItem::where('user_id', $user->id)->delete();

        return response()->json(['message' => 'Đơn hàng đã được tạo!', 'order' => $order]);
    }

    //  Cập nhật trạng thái đơn hàng (Admin)
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', Rule::in(['cho_xac_nhan', 'dang_xu_ly', 'dang_giao', 'da_giao', 'da_huy'])],
            'payment_status' => ['nullable', Rule::in(['cho_thanh_toan', 'da_thanh_toan', 'that_bai'])],
        ]);

        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Không tìm thấy đơn hàng!'], 404);
        }

        if ($request->has('status')) {
            $order->status = $request->status;
        }
        if ($request->has('payment_status')) {
            $order->payment_status = $request->payment_status;
        }

        $order->save();

        return response()->json(['message' => 'Trạng thái đơn hàng đã được cập nhật!', 'order' => $order]);
    }
}
