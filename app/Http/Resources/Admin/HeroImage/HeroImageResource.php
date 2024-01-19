<?php

namespace App\Http\Resources\Admin\HeroImage;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HeroImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'image'=> $this->getFirstMediaUrl()
        ];
    }
}
