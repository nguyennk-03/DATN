<?php
namespace App\Models\Api;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariant extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'size_id', 'color_id', 'stock'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }
}
