<?php

namespace App\Http\Resources\User\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CheckOutOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id ,
            'order_id' => $this->order_id ,
            'created_at' => $this->created_at->format('Y-m-d H:i') ,
            'address' => $this->address,
            'invoice_value' => $this->invoice->invoice_value ,
            'shipping' => $this->invoice?->shipment_fees , 
            'total' => $this->invoice?->total ,
            'products' => ShowResource::collection($this->orderProducts),
        ];
    }
}
