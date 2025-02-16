<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'status', 'total_price', 'payment_status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function getStatusTextAttribute()
    {
        $statuses = [
            'pending' => 'Chờ xử lý',
            'processing' => 'Đang xử lý',
            'shipped' => 'Đã giao',
            'completed' => 'Hoàn tất',
            'canceled' => 'Đã hủy',
        ];
        return $statuses[$this->status] ?? 'Không xác định';
    }

    public function getPaymentStatusTextAttribute()
    {
        $paymentStatuses = [
            'pending' => 'Chờ thanh toán',
            'paid' => 'Đã thanh toán',
            'failed' => 'Thất bại',
        ];
        return $paymentStatuses[$this->payment_status] ?? 'Không xác định';
    }
}
