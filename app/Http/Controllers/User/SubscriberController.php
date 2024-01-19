<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactUsRequest;
use App\Http\Requests\User\SubscribeRequest;
use App\Jobs\ContactUs;
use App\Models\Subscriber;
use App\Repositories\Contracts\ISubscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function store(SubscribeRequest $request){
        Subscriber::firstOrCreate(['email' => $request->email]);
        return self::success('You have successfully subscribed');
    }


    public function contactUs(ContactUsRequest $request){
        $data = $request->validated();
        dispatch(new ContactUs($data)); // send mail with request to admin 
        return self::success('The request has been registered successfully');
    }

    
}
