<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\RegisterRequest;
use App\Jobs\VerificationCodeJob;
use App\Mail\SendVerificationMail;
use App\Models\User;
use Carbon\Carbon;
use Exception;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $user = User::create($data);
            $user->assignRole('user');
            $user->vcode = rand(0, 99999);
            Mail::to($user)->send(new \App\Mail\SendVerificationMail(['code' => $user->vcode, 'year' => Carbon::now()->year]));
            DB::commit();
            return self::success(__('messages.registered'));
        }
        catch (Exception $ex) {
            DB::rollback();
            return self::failure('somethings went wrongs', 450);
        }
    }
}
