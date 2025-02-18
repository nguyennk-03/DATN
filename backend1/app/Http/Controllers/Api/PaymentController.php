<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PaymentController extends Controller
{
    use AuthorizesRequests;

    // Lấy thông tin thanh toán của một đơn hàng
    public function show($orderId)
    {
        $order = Order::findOrFail($orderId);

        // Kiểm tra quyền truy cập
        $this->authorize('view', $order);

        $payment = $order->payments->first(); // Lấy thanh toán đầu tiên của đơn hàng
        if (!$payment) {
            return response()->json(['message' => 'Không tìm thấy thông tin thanh toán.'], 404);
        }

        return response()->json($payment);
    }

    // Tạo thanh toán cho đơn hàng
    public function store(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        // Kiểm tra quyền truy cập
        $this->authorize('update', $order);

        // Xác thực dữ liệu đầu vào
        $validated = $request->validate([
            'payment_method' => 'required|in:momo,vnpay,paypal,cod',
            'amount' => 'required|numeric|min:0',
        ]);

        // Kiểm tra xem tổng giá trị thanh toán có đúng không
        if ($validated['amount'] != $order->total_price) {
            return response()->json(['message' => 'Số tiền thanh toán không đúng.'], 400);
        }

        // Tạo thanh toán mới
        $payment = Payment::create([
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'payment_method' => $validated['payment_method'],
            'amount' => $validated['amount'],
            'status' => 'pending', // Mặc định là pending
        ]);

        return response()->json($payment, 201);
    }

    // Cập nhật trạng thái thanh toán
    public function updateStatus(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        // Kiểm tra quyền truy cập
        $this->authorize('update', $order);

        // Xác thực dữ liệu đầu vào
        $validated = $request->validate([
            'status' => 'required|in:pending,completed,failed',
        ]);

        $payment = $order->payments->first(); // Lấy thanh toán đầu tiên của đơn hàng
        if (!$payment) {
            return response()->json(['message' => 'Không tìm thấy thông tin thanh toán.'], 404);
        }

        // Cập nhật trạng thái thanh toán
        $payment->status = $validated['status'];
        $payment->save();

        return response()->json($payment);
    }

    // Lấy danh sách tất cả các thanh toán
    public function index()
    {
        $payments = Payment::all();
        return response()->json($payments);
    }

    // Xóa thanh toán (nếu cần)
    public function destroy($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        $this->authorize('delete', $payment); // Kiểm tra quyền xóa

        $payment->delete();
        return response()->json(['message' => 'Thanh toán đã được xóa.']);
    }
}