<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\CheckResetPasswordRequest;
use App\Http\Requests\User\Auth\EditPasswordRequest;
use App\Http\Requests\User\Auth\ResetPasswordRequest;
use App\Http\Traits\HttpResponse;
use App\Models\User;
use App\Traits\OtpTrait;

class ResetPasswordController extends Controller
{
    use HttpResponse, OtpTrait;

    /**
     * @param ResetPasswordRequest $request
     * @return \Illuminate\Http\Response
     *  user will request to reset password, this function will generate verification code and send it to user.
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        $credentials = $request->validated();
        $user = User::query()->where('email', $credentials['email'])->first();
        $response = $this->checkConditions($user);
        if ($response->getStatusCode() != 200) {
            return $response;
        }
        self::sendCode($user);
        return self::success(trans('messages.verified_code_sent'));
    }

    /**
     * @param CheckResetPasswordRequest $request
     * @return \Illuminate\Http\Response
     *  after send the code for user, will check if entered code right
     */
    public function checkCode(CheckResetPasswordRequest $request): \Illuminate\Http\Response
    {
        $credentials = $request->validated();
        $user = User::query()->where('email', $credentials['email'])->first();
        $response = $this->checkConditions($user);
        if ($response->getStatusCode() != 200) {
            return $response;
        }
        elseif ($user->vcode != $request->code) {
            return self::failure(trans('messages.wrong_code'), 400);
        }
        return self::success('The verification code is correct!');
    }

    /**
     * @param EditPasswordRequest $request
     * @return \Illuminate\Http\Response
     *  after check the code, user can edit password
     */
    public function editPassword(EditPasswordRequest $request): \Illuminate\Http\Response
    {
        $credentials = $request->validated();
        $user = User::query()->where('email', $credentials['email'])->first();
        $response = $this->checkConditions($user);
        if ($response->getStatusCode() != 200) {
            return $response;
        }
        elseif ($user->vcode != $request->code) {
            return self::failure(trans('messages.wrong_code'), 400);
        }

        $user->forceFill(['password' => $credentials['new_password']]);
        return self::success('password changed successfully!');
    }

    /**
     * @param $user
     * @return \Illuminate\Http\Response
     */
    public function checkConditions($user)
    {
        if (!$user) {
            return self::failure(trans('messages.failed'), 400);
        }
        return self::success('');
    }
}
