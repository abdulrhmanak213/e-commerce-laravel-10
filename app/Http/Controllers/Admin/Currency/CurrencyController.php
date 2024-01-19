<?php

namespace App\Http\Controllers\Admin\Currency;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Currency\CurrencyRequest;
use App\Http\Resources\Admin\Currency\CurrencyResource;
use App\Models\Currency;
use App\Repositories\Contracts\ICurrency;
use Illuminate\Http\Request;
use phpseclib3\Exception\FileNotFoundException;
use Illuminate\Support\Facades\Cache;

class CurrencyController extends Controller
{
    public function show(): \Illuminate\Http\Response
    {
        $currency = Currency::query()->first();
        return self::returnData('currency', CurrencyResource::make($currency));
    }

    public function update(CurrencyRequest $request): \Illuminate\Http\Response
    {
        $currency = Currency::query()->first();
        $currency->update([
            'value' => $request->value,
        ]);
        Cache::flush('dolar_price');
        return self::success('updated successfully!');
    }
}
