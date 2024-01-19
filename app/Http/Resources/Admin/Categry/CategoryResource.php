<?php

namespace App\Http\Resources\Admin\Categry;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'title' => $this->title,
            'image' => $this->getFirstMediaUrl('category_image'),
            'translation' => $this->translations,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
