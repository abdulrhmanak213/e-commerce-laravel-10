<?php

namespace App\Http\Resources\Admin\City;

use App\Http\Resources\Admin\Country\CountryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'shipment_fees' => $this->shipment_fees,
            'country' => new CountryResource($this->country),
            'translations' => $this->translations,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }


}
