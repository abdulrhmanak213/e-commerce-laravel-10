<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ReviewRate extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'user_id',
        'title',
        'description',
        'rate',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getGalleryAttribute()
    {
        $images = $this->getMedia();
        $gallery = array();
        for ($i = 0; $i < sizeof($images); $i++) {
            $gallery[$i]['url'] = $images[$i]->getUrl();
            $gallery[$i]['id'] = $images[$i]->id;
        }
        return $gallery;
    }
}
