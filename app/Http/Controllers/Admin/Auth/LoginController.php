<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\Response
     * this function for admin login, if user type normal user thin it will forbidden.
     */
    public function login(LoginRequest $request)//: \Illuminate\Http\Response
    {
        $user_credentials = $request->validated();
        if (!Auth::attempt($user_credentials)) {
            return self::failure(trans('messages.failed'), 400);
        }
        $user = Auth::user();
        if ($this->checkUserRole($user) || $user->is_admin == 0) {
            return self::failure(trans('messages.forbidden'), 403);
        }
        $token = $user->createToken('Admin Token')->accessToken;
        return self::returnData('access_token', $token);
    }

    /**
     * @param $user
     * @return bool
     * this function to check if user role is admin or normal user, if normal then return false because it's can access
     */
    public function checkUserRole($user): bool
    {
        if ($user->getRoleNames()->first() == 'admin')
            return false;
        return true;
    }
}
