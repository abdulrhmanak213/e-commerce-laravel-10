<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Category extends Model implements TranslatableContract , HasMedia
{
    use  Translatable, InteractsWithMedia, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
        public $translatedAttributes = ['title'];
    protected $hidden = ['translations'];
    //////////////////////////////// relations ////////////////////////////////
    public function products(){
        return $this->hasMany(Product::class);
    }

    public function scopeFilter($query, $filters)
    {
        if($filters==null){
            return $query;
        }
        foreach ($filters as $filter) {
            if ($filter['value'] ) {
                $query->whereTranslationLike($filter['column'], '%' . $filter['value'] . '%');
            }
        }
        return $query;
    }

    public function getTranslatedNameAttribute(){
        return   $translatedAttributes = $this->translatedAttributes;
    }

}
