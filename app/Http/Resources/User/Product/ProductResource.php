<?php

namespace App\Http\Resources\User\Product;

use App\Http\Resources\User\Color\IndexResource;
use App\Http\Resources\User\Size\IndexResource as SizeIndexResource;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $sale = Cache::rememberForever('sale', function () {
            return Sale::query()->first();
        });
        $location = Config::get('app.location');
        return [
            'id' => $this->id ,
            'name' => $this->name ,
            'description' => $this->description ,
            'price' => $this->price ,
            'price_after_sale' => $this->when($this->is_on_sale && $sale != null , floor($this->price - (($this->price * $sale?->value) / 100))),
            'is_on_sale' => $this->is_on_sale ,
            'sale_value' => $this->when($this->is_on_sale ,$sale?->value),
            'currency_symbol'=>$location == 'Syria'?'SYP':'USD',
            'quantity' => $this->quantity ,
            'gallery' => $this->gallery ,
            'product_colors' => IndexResource::collection($this->productColors),
            'product_sizes' => SizeIndexResource::collection($this->productSizes)

        ];
    }



}
