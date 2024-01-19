<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\HeroImage\HeroImageResource;
use App\Models\HeroImage;
use App\Repositories\Contracts\IHeroImage;
use Illuminate\Http\Request;

class HeroImageController extends Controller
{ 
    public function show(){
        $heroImage = HeroImage::firstOrNew();
        return self::returnData('heroImage',HeroImageResource::make($heroImage));
    }
}
