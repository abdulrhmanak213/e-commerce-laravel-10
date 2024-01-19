<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class City extends Model implements TranslatableContract
{
    use  Translatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id',
        'shipment_fees',
    ];

    public $translatedAttributes = ['name'];
    protected $hidden = ['translations'];


    public function newQuery()
    {
        $query = parent::newQuery();
        return $query->with('translations');
    }


    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTranslatedNameAttribute()
    {
        return $translatedAttributes = $this->translatedAttributes;
    }

    protected function getShipmentFeesAttribute($value)
    {
            if (Config::get('app.location') == 'Syria') {
                return  $this->getPriceInSYP($value);
            }
            return  $value;
    }

    public function getPriceInSYP($value)
    {
        $currency = Cache::remember('currency', now()->addMinutes(2), function () {
            return Currency::query()->first();
        });
        return $value * $currency->value;
    }





}
