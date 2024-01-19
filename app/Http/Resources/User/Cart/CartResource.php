<?php

namespace App\Http\Resources\User\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'invoice_value'=>$this->invoice_value,
            'shipment_fees'=>$this->shipment_fees,
            'total'=>$this->total,
            'products'=>CartProductResource::collection($this->cart_products),
            ];
    }
}
