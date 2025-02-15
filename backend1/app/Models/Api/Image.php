<?php
namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'image_url'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
