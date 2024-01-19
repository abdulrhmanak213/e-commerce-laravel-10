<?php

namespace App\Http\Resources\Admin\ReviewRate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewRatesResource extends JsonResource
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
            'description'=>$this->description,
            'rate'=>$this->rate,
            'gallery'=>$this->gallery,
            'is_shown'=>$this->is_shown,
            'created_at'=>$this->created_at
        ];
    }



}
