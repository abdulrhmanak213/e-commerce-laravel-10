<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UserRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\Admin\User\UserIndexResource;
use App\Http\Resources\Admin\User\UserResource;
use App\Models\User;
use App\Repositories\Contracts\IUser;
use Illuminate\Http\Request;
use Psy\Util\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request)
    {
        $query = User::query();
        $query = $query->where( ['is_admin' => 0]);
        if ($request->query('with_trashed')) {
            $query = $query->onlyTrashed($query);
        }
        if ($request->query('value')) {
            $query = $query->where(['email' => $request->query('value')]);
        }
        $users = $query->paginate( $request->count);
        return self::returnData('users', UserIndexResource::collection($users), $users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $data['verified_at'] = now();
        $user = User::query()->forceCreate($data);
        $user->assignRole('user');
        $user->save();
        return self::success('User created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::query()->where('is_admin', 0)->findOrFail($id);
        return self::returnData('users', new UserResource($user));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        $data = $request->validated();
        User::query()->findOrFail($id)->update($data);
        return self::success('User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::query()->findOrFail($id);
        $user->delete($user);
        return self::success('User deleted successfully!');
    }

    public function restore(string $id): \Illuminate\Http\Response
    {
        $user = User::query()->withTrashed()->findOrFail($id);
        $user->restore();
        return self::success('User restored successfully!');
    }

    public function blockToggle(string $id)
    {
        $user = User::query()->findOrFail($id);
        if ($user->is_blocked) {
            $user->forceFill(['is_blocked' => 0])->save();
            return self::success('User unblocked successfully!');
        }
        $user->forceFill(['is_blocked' => 1])->save();
        return self::success('User blocked successfully!');
    }
}
