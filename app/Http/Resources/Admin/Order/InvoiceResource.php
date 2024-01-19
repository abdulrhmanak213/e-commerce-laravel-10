<?php

namespace App\Http\Resources\Admin\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            'user_id'=>$this->user_id,
            'order_id'=>$this->order_id,
            'invoice_value'=>$this->invoice_value,
            'shipment_fees'=>$this->shipment_fees,
            'total'=>$this->total,
            'currency' => $this->currency
        ];
    }



}
