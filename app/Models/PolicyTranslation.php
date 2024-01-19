<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PolicyTranslation extends Model
{
    protected $fillable = [
        'message',
        'title',
    ];
    public $timestamps = false;
}
