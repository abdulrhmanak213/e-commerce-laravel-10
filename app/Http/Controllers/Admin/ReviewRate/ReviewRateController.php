<?php

namespace App\Http\Controllers\Admin\ReviewRate;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\Admin\ReviewRate\ReviewRatesIndexResource;
use App\Http\Resources\Admin\ReviewRate\ReviewRatesResource;
use App\Models\ReviewRate;
use App\Repositories\Contracts\IReview;
use Illuminate\Http\Request;

class ReviewRateController extends Controller
{
    public function index(SearchRequest $request): \Illuminate\Http\Response
    {
        $query = ReviewRate::query();
        if ($request->value) {
            $query = $query->where($query, ['invoice_id', $request->value]);
        }
        $reviews = $query->paginate($request->count);
        return self::returnData('reviews', ReviewRatesIndexResource::collection($reviews), $reviews);
    }

    public function show(string $id): \Illuminate\Http\Response
    {
        $review = ReviewRate::query()->findOrFail($id);
        return self::returnData('review', new ReviewRatesResource($review));
    }

    public function showToggle(string $id)//: \Illuminate\Http\Response
    {
        $review = ReviewRate::query()->findOrFail($id);
        if ($review->is_shown) {
            $review->forceFill(['is_shown' => false])->save();
            return self::success('ReviewRate un shown successfully!');
        }
        $review->forceFill(['is_shown' => true])->save();
        return self::success('ReviewRate shown successfully!');
    }
}
