<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\User;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'user_id', 'payment_method', 'amount', 'status'];

    // Quan hệ với đơn hàng
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Quan hệ với người dùng
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Lấy văn bản trạng thái thanh toán
    public function getStatusTextAttribute()
    {
        $statuses = [
            'pending' => 'Chờ thanh toán',
            'paid' => 'Đã thanh toán',
            'failed' => 'Thất bại',
        ];
        return $statuses[$this->status] ?? 'Không xác định';
    }
}

