<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\Country\CityResource;
use App\Http\Resources\User\Country\CountryResource;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function getCountry()
    {
        $countries = Country::query()->latest()->get();
        return self::returnData('countries', CountryResource::collection($countries));
    }


    public function getCity()
    {
        $cities = City::query()->latest()
            ->when(request()->country_id, function ($query) {
                $query->where('country_id', request()->country_id);
            })->get();
        return self::returnData('cities', CityResource::collection($cities));
    }
}
