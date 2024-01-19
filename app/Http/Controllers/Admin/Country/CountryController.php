<?php

namespace App\Http\Controllers\Admin\Country;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Country\CountryRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\Admin\Country\CountryIndexResource;
use App\Http\Resources\Admin\Country\CountryResource;
use App\Http\Traits\HttpResponse;
use App\Models\Country;
use App\Repositories\Contracts\ICountry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\Count;

class CountryController extends Controller
{
    use HttpResponse;

    public function index(SearchRequest $request): \Illuminate\Http\Response
    {
        $country = Country::query()->with('translations')->paginate($request->count);
        return self::returnData('countries', CountryIndexResource::collection($country), $country);
    }

    public function store(CountryRequest $request)
    {
        $country = Country::query()->create();
        $this->translate($country, ['name_en' => $request->name_en, 'name_ar' => $request->name_ar, 'shipment_fees' => $request->shipment_fees]);
        return self::success('Country created successfully');
    }

    public function show($id): \Illuminate\Http\Response
    {
        $country = Country::query()->findOrFail($id);
        return self::returnData('country', new CountryResource($country));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CountryRequest $request, $id): \Illuminate\Http\Response
    {
        $country = Country::query()->findOrFail($id);
        $this->translate($country, ['name_en' => $request->name_en, 'name_ar' => $request->name_ar]);
        return self::success('Country updated successfully');
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
