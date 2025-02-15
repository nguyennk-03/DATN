<?php
namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Api\Product;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'logo'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
