<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermTranslation extends Model
{
    protected $fillable = [
        'message',
        'title'
    ];
    public $timestamps = false;
}
