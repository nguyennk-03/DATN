<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Image;
use App\Models\ProductVariant;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'price', 'stock', 'category_id', 'brand_id'];

    // Quan hệ với danh mục
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Quan hệ với thương hiệu
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // Quan hệ với hình ảnh
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    // Quan hệ với các biến thể sản phẩm
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }


    // Phương thức này lấy hình ảnh của biến thể đầu tiên hoặc hình ảnh chính
    public function getVariantImageAttribute()
    {
        return optional($this->variants()->first())->img ?? $this->img;
    }
   
}
