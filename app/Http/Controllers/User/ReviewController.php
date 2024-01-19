<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ReviewRequest;
use App\Http\Resources\User\ReviewResource;
use App\Models\Order;
use App\Models\ReviewRate;
use App\Repositories\Contracts\IReview;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
   
    public function review(Order $order ,ReviewRequest $request){

        $user = auth('user')->id();
        // Check if the authenticated user is the owner, and the status of the order is Complete
        if( $order->status !== 'done'|| $user != $order->user_id )   
            return self::failure("you can't complete this action",450);

        $data = $request->only('title','description','rate');
        $data['user_id'] = $user ;
        $data['order_id'] = $order->id ;

        $review = ReviewRate::create($data);

        return self::success('review added successfully');
    }


    public function index(){
        $reviews = ReviewRate::with('user')
        ->latest()->paginate(2);
        return self::returnData('reviews' , ReviewResource::collection($reviews) ,$reviews) ;
    }
}
