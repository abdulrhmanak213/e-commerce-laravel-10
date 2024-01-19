<?php

namespace App\Http\Controllers\Admin\HeroImage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HeroImage\HeroImageRequest;
use App\Http\Resources\Admin\HeroImage\HeroImageResource;
use App\Models\HeroImage;
use App\Repositories\Contracts\IHeroImage;
use Illuminate\Http\Request;

class HeroImageController extends Controller
{
    public function show()
    {
        $heroImage = HeroImage::query()->firstOrCreate([]);
        return self::returnData('hero_image', HeroImageResource::make($heroImage));
    }

    public function store(HeroImageRequest $request)
    {
        $heroImage = HeroImage::query()->firstOrCreate([]);
        $heroImage->clearMediaCollection();
        $heroImage->addMedia($request->image)->toMediaCollection();
        return self::success('Success');
    }
}
