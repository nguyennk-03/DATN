<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'created_at' => $this->formatted_created_at,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
        ];
    }
}
