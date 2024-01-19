<?php

namespace App\Http\Resources\User\Cart;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;

class CartProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $sale = Cache::rememberForever('sale',function(){
            return Sale::first();
        });
        
        return [
            'id'=>$this->product->id,
            'product_name'=>$this->product->name,
            'product_price'=>$this->product->price,
            'product_image'=>$this->product->getFirstMediaUrl('product_cover'),
            'quantity'=>$this->quantity,
            'product_quantity' => $this->product?->quantity ,
            'is_on_sale' => $this->product->is_on_sale ,
            'sale_value' => $this->when($this->product->is_on_sale ,$sale?->value) ,
            'price_after_sale' => $this->when($this->product->is_on_sale && $sale != null , floor($this->product->price - (($this->product->price * $sale->value) / 100))),
            'color' => $this->color ,
            // 'color_id' => 
            'size' => $this->size  
        ];
    }
}
