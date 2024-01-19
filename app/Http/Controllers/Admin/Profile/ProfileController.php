<?php

namespace App\Http\Controllers\Admin\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\ChangePassswordRequest;
use App\Http\Resources\Admin\Admin\AdminResource;
use App\Repositories\Contracts\IUser;
use Illuminate\Http\Request;

class ProfileController extends Controller
{


    /**
     * @return \Illuminate\Http\Response
     * return admin profile
     */
    public function show()
    {
        $user = auth()->user();
        return self::returnData('admin', AdminResource::make($user));
    }

    /**
     * @param ChangePassswordRequest $request
     * @return \Illuminate\Http\Response
     * change password for admin
     */
    public function changePassword(ChangePassswordRequest $request)
    {
        $admin = auth()->user();
        $admin->forceFill(['password' => $request->new_password])->save();
        return self::success('Success');
    }
}
