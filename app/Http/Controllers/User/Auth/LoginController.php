<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        if (!Auth::attempt($credentials)) {
            return self::failure(trans('messages.failed'), 400);
        }
        $user = Auth::user();
        if ($this->checkUserRole($user) || $user->is_admin == 0) {
            $token = $user->createToken('User Token')->accessToken;
            return self::returnData('access_token', $token);
        }

        return self::failure(trans('messages.forbidden'), 401);
    }

    public function logout()
    {
        auth('user')->user()->token()->revoke();
        return self::success(trans('messages.logged_out'));
    }

    public function checkUserRole($user): bool
    {
        if ($user->getRoleNames()->first() != 'user')
            return false;
        return true;
    }
}
