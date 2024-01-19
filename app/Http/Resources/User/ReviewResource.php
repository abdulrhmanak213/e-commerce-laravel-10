<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'rate' => $this->rate ,
            'title' => $this->title ,
            'description' => $this->description ,
            'created_at' => $this->created_at->format('J I ,m'),
            'user_name' => $this->user?->first_name . ' ' .$this->user?->last_name
        ];
    }
}
