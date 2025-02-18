<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Size;
use App\Models\Color;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'size_id', 'color_id'];

    // Quan hệ với sản phẩm
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Quan hệ với kích cỡ
    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    // Quan hệ với màu sắc
    public function color()
    {
        return $this->belongsTo(Color::class);
    }
}
