<?php 

namespace App\Traits ;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

trait OtpTrait {
    public function sendCode($user)
    {
        $verification_code = rand(100000, 999999);
        $user->forceFill(['vcode' => $verification_code])->save();
        Mail::to($user)->send(new \App\Mail\SendCodeMail(['code' => $verification_code, 'year' => Carbon::now()->year]));
    }
    public function sendVerificationCode($user)
    {
        $verification_code = rand(100000, 999999);
        $user->forceFill(['vcode' => $verification_code])->save();
        Mail::to($user)->send(new \App\Mail\SendVerificationMail(['code' => $verification_code, 'year' => Carbon::now()->year]));
    }
}