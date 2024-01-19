<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'cart_id',
        'quantity',
        'color',
        'size'
    ];

    public function cart(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }

    // public function color(){
    //     return $this->belongsTo(Color::class);
    // }

    // public function size(){
    //     return $this->belongsTo(ProductSize::class ,'size_id');
    // }


    public function scopeProduct($query ,$product ,$cart ,$color ,$size){
        return $query->where([
            'product_id'=>$product->id,
            'cart_id'=>$cart->id ,
            'color'=>$color ,
            'size'=>$size ,
        ]);
    }
}
