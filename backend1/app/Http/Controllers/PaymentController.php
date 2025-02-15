<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    //  Tạo thanh toán cho một đơn hàng
    public function store(Request $request)
    {
        $user = Auth::user();

        // Kiểm tra dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'payment_method' => ['required', Rule::in(['momo', 'vnpay', 'paypal', 'cod'])],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

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

    //  Admin: Xem danh sách thanh toán
    public function index()
    {
        $payments = Payment::with('order.user')->orderBy('created_at', 'desc')->get();
        return response()->json(['payments' => $payments]);
    }

    //  Admin: Cập nhật trạng thái thanh toán
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => ['required', Rule::in(['cho_xu_ly', 'hoan_tat', 'that_bai'])],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $payment = Payment::find($id);
        if (!$payment) {
            return response()->json(['message' => 'Không tìm thấy thanh toán!'], 404);
        }

        $payment->status = $request->status;
        $payment->save();

        return response()->json([
            'message' => 'Cập nhật trạng thái thanh toán thành công!',
            'payment' => $payment
        ]);
    }
}
