<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model implements TranslatableContract
{
    protected $fillable = [
        'phone',
        'location',
    ];

    use Translatable;
    public $translatedAttributes = [ 'postcode', 'store_location'];

}
