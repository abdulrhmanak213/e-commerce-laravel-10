<?php

namespace App\Http\Resources\User\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product_id' => $this->product?->id ,
            'name' => $this->product?->name ,
            'image' =>$this->product?->getFirstMediaUrl('product_cover'),
            'color' => $this->color ,
            'size' => $this->size,
            'price' => $this->price ,
            'quantity' => $this->quantity 
        ];
    }
}
