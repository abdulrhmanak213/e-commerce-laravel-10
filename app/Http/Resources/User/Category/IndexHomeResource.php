<?php

namespace App\Http\Resources\User\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexHomeResource extends JsonResource
{
    
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id ,
            'title' => $this->title ,
            'image' => $this->getFirstMediaUrl('category_image') ,
        ];
    }



}
