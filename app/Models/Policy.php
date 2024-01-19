<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Policy extends Model implements TranslatableContract
{
    use Translatable;

    protected $fillable = [];
    public $translatedAttributes = ['message', 'title'];
    protected $hidden = ['translations'];

    public function getTranslatedNameAttribute()
    {
        return $translatedAttributes = $this->translatedAttributes;
    }

}
