<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements TranslatableContract, HasMedia
{
    use  Translatable, InteractsWithMedia, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'price',
        'quantity',
    ];

    public $translatedAttributes = ['name', 'description'];
    protected $hidden = ['translations'];
    protected $appends = ['rate'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('product_images');
        $this->addMediaCollection('product_cover');
    }

    public function newQuery()
    {
        $query = parent::newQuery();
        $query->with('translations')
            ->with('media');
        return $query;
    }

    protected function price(): Attribute
    {
        if (Config::get('app.location') == 'Syria') {
            return Attribute::make(
                get: fn(string $value) => $this->getPriceInSYP($value),
            );
        }
        return Attribute::make(
            get: fn($value) => $value,
        );
    }

    public function getPriceInSYP($value)
    {
        $currency = Cache::remember('currency', now()->addMinutes(2), function () {
            return Currency::query()->first();
        });
        return $value * $currency->value;
    }

    public function productColors(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Color::class, 'product_colors');
    }

    public
    function productSizes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductSize::class);
    }

    public
    function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public
    function orderProducts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }

    public
    function getGalleryAttribute()
    {
        $images = $this->getMedia('product_images');
        $gallery = array();
        for ($i = 0; $i < sizeof($images); $i++) {
            $gallery[$i]['url'] = $images[$i]->getUrl();
            $gallery[$i]['id'] = $images[$i]->id;
        }
        return $gallery;
    }

    public function scopeFilter($query, $filters)
    {
        if ($filters == null) {
            return $query;
        }
        foreach ($filters as $filter) {
            if ($filter['value']) {
                $query->whereTranslationLike($filter['column'], '%' . $filter['value'] . '%');
            }
        }
        return $query;
    }

    public function getRateAttribute()
    {
        $id = $this->id;
        $reviews = ReviewRate::query()
            ->where('is_shown', true)
            ->whereHas('order', function ($query) use ($id) {
                $query->whereHas('orderProducts', function ($query) use ($id) {
                    $query->where('product_id', $id);
                });
            })
            ->get();
        if (count($reviews) == 0) {
            return 0;
        }
        $rate = 0;
        foreach ($reviews as $review) {
            $rate += $review->rate;
        }
        return $rate / count($reviews);
    }

    public function getTranslatedNameAttribute()
    {
        return $translatedAttributes = $this->translatedAttributes;
    }
}
