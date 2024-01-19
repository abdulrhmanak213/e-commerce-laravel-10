<?php

namespace App\Http\Controllers\Admin\Sale;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Sale\SaleRequest;
use App\Http\Resources\Admin\Sale\SaleResource;
use App\Models\Sale;
use App\Repositories\Contracts\ISale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SaleController extends Controller
{

    public function show()
    {
        $sale = Sale::query()->firstOrCreate([]);
        return self::returnData('sale', SaleResource::make($sale));
    }

    public function store(SaleRequest $request)
    {
        $sale = Sale::query()->firstOrCreate([]);
        $sale->update(['value' => $request->value]);
        Cache::flush('dolar_price');
        return self::success('Success');
    }

}
