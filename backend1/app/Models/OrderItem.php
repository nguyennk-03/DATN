<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\ProductVariant;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'product_variant_id', 'quantity', 'price'];

    // Quan hệ với đơn hàng
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Quan hệ với biến thể sản phẩm
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
