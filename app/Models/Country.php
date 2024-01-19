<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Country extends Model implements TranslatableContract
{
    use Translatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    public $translatedAttributes = ['name'];
    protected $hidden = ['translations'];

    public function getTranslatedNameAttribute(){
        return   $translatedAttributes = $this->translatedAttributes;
    }
}
