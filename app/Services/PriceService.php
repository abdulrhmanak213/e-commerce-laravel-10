<?php

namespace App\Services ;

use App\Models\Currency;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class PriceService {

    public function getPrice(){
        $data['currency'] = Config::get('app.location') == 'Syria' ? 'SYP' : 'USD';
        $data['exchange_rate'] = Config::get('app.location') == 'Syria' ? floor($this->getDolarPrice()) : null;
        return $data ;
    }

    private function getDolarPrice(){
        return   $price = Cache::rememberForever('dolar_price',function(){
              return Currency::first()->value ;
          });
      }

    public function getSaleValue(){
        $sale = Cache::rememberForever('sale', function () {
            return Sale::query()->first();
        });
    }
}
