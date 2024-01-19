<?php

namespace App\Http\Controllers\Admin\City;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\City\CityRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\Admin\City\CityResource;
use App\Models\City;
use App\Repositories\Contracts\ICity;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(SearchRequest $request): \Illuminate\Http\Response
    {
        $city = City::query()->with('translations')->paginate($request->count);
        return self::returnData('cities', CityResource::collection($city), $city);
    }

    public function store(CityRequest $request): \Illuminate\Http\Response
    {
        $city = City::query()->create(['country_id' => $request->country_id, 'shipment_fees' => $request->shipment_fees]);
        $this->translate($city, ['name_en' => $request->name_en, 'name_ar' => $request->name_ar]);
        return self::success('City created successfully');
    }

    public function show($id): \Illuminate\Http\Response
    {
        $city = City::query()->findOrFail($id);
        return self::returnData('city', new CityResource($city));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CityRequest $request, $id): \Illuminate\Http\Response
    {
        $city = City::query()->findOrFail($id);
        $city->update(['country_id' => $request->country_id, 'shipment_fees' => $request->shipment_fees]);
        $this->translate($city, ['name_en' => $request->name_en, 'name_ar' => $request->name_ar]);
        return self::success('City updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function translate($record, $data)
    {
        foreach ($this->languages as $language) {
            $record->translateOrNew($language)->name = $data['name_' . $language];
        }
        $record->save();
    }
}
