<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class HeroImage extends Model implements HasMedia
{
    use InteractsWithMedia;

    public function newQuery()
    {
        $query = parent::newQuery();
        $query->with('media');
        return $query;
    }
}
