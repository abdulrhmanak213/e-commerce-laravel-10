<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
    //////////////////////////////// relations ////////////////////////////////
    public function products(){
        return $this->belongsToMany(Product::class);
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

}
