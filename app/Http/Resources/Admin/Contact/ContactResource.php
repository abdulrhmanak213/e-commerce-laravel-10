<?php

namespace App\Http\Resources\Admin\Contact;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'phone'=>$this?->phone,
            'email'=>$this?->email,
            'location'=>$this?->location,
            'store_location'=>$this?->store_location,
            'postcode'=>$this?->whenNotNull($this->postcode),
            'translation'=>$this->whenNotNull('translations')
        ];
    }
}
