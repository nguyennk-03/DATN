<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Order;
use App\Http\Requests\StorePaymentRequest;  // Import the StorePaymentRequest class
use Illuminate\Support\Facades\Auth;  // Import the Auth facade

class PaymentController extends Controller
{
    // Tạo thanh toán cho một đơn hàng
    public function store(StorePaymentRequest $request)
    {
        $user = Auth::user();

        // Validate the request with StorePaymentRequest
        $order = Order::where('id', $request->order_id)->where('user_id', $user->id)->first();

        if (!$order) {
            return response()->json(['message' => 'Không tìm thấy đơn hàng hoặc bạn không có quyền truy cập!'], 404);
        }

        // Kiểm tra trạng thái thanh toán
        if ($order->payment_status !== 'cho_thanh_toan') {
            return response()->json(['message' => 'Đơn hàng này đã được thanh toán hoặc bị hủy!'], 400);
        }

        // Tạo thanh toán
        $payment = Payment::create([
            'order_id' => $order->id,
            'user_id' => $user->id,
            'payment_method' => $request->payment_method,
            'amount' => $order->total_price,
            'status' => 'cho_xu_ly',
        ]);

        return response()->json([
            'message' => 'Thanh toán đang được xử lý!',
            'payment' => $payment
        ], 201);
    }
}
