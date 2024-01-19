<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Traits\HttpResponse;
use Illuminate\Http\Request;

/**
 *
 */
class LogoutController extends Controller
{
    use HttpResponse;

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response'
     * logout function for admin.
     */
    public function logout(Request $request): \Illuminate\Http\Response
    {
        $all_devices = $request->query('all_devices');
        $user = auth()->user();
        if ($all_devices == true) {
            foreach ($user->tokens as $token) {
                $token->revoke();
            }
            return self::success(trans('messages.logged_out_all'));
        }
        $request->user()->token()->revoke();
        return self::success(trans('messages.logged_out'));
    }
}
