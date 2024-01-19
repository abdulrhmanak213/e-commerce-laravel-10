<?php

namespace App\Http\Traits;

trait translateStatus
{
    public function translate($status){
        $lang = request()->header('lang');
        if($status == 'done')
            return $lang == 'ar' ? 'تم' : 'done' ;
        elseif($status == 'canceled')
            return $lang == 'ar' ? 'ملغية' : 'canceled' ;
        else
             return $lang == 'ar' ? 'معلق' : 'pending' ;
    }
}