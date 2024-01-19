<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable =['name','symbol','value'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i' ,
        'updated_at' => 'datetime:Y-m-d H:i' ,
    ];

}
