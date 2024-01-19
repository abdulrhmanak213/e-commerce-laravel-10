<?php

namespace App\Http\Resources\User\Product;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use phpDocumentor\Reflection\Types\Parent_;

class IndexResource extends JsonResource
{


    public function toArray(Request $request): array
    {
     
        $sale = Cache::get('sale');
        $location = Config::get('app.location');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'price_after_sale' => $this->when($this->is_on_sale && $sale != null, floor($this->price - (($this->price * $sale?->value) / 100))),
            'currency_symbol' => $location == 'Syria' ? 'SYP' : 'USD',
            'image' => $this->getFirstMediaUrl('product_cover'),
            'is_on_sale' => $this->is_on_sale,
            'sale_value' => $this->when($this->is_on_sale, $sale?->value),
            'category_id' => $this->category_id ,
        ];
    }

}
