<?php

namespace App\Http\Resources\User\Order;

use App\Http\Traits\translateStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    use translateStatus ;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'shipment_fees' => $this->invoice->shipment_fees,
            'total' => $this->invoice->total ,
            'status' => self::translate($this->status),
            'created_at' => $this->created_at->format('Y-m-d H:i ')
        ];
    }
}
