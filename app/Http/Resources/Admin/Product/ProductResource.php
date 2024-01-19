<?php

namespace App\Http\Resources\Admin\Product;

use App\Http\Resources\Admin\Color\ColorResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'category_id' => $this->category_id,
            'category_title' => $this->category?->title,
            'colors' => ColorResource::collection($this->productColors),
            'sizes' => $this->productSizes,
            'gallery' => $this->gallery,
            'translation' => $this->translations,
            'cover' => $this->getFirstMediaUrl('product_cover'),
            'is_on_sale'=>$this->is_on_sale,
            'deleted_at' => $this->deleted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
