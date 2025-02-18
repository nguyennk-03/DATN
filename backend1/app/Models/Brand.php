<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'logo'];

    // Quan hệ với các sản phẩm
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
