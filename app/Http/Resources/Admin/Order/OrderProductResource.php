<?php

namespace App\Http\Resources\Admin\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this->product);
        return [
            'id'=>$this->product?->id ,
            'color'=>$this->color ,
            'size'=>$this->size,
            'price'=>$this->price,
            'quantity'=>$this->quantity,
            'name'=>$this->product?->name,
            'description'=>$this->product?->description,
            'image' => $this->product?->getFirstMediaUrl('product_cover')
        ];
    }
}
