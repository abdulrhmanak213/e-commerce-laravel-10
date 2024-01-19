<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admin\AdminRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\Admin\Admin\AdminResource;
use App\Http\Traits\HttpResponse;
use App\Models\User;
use App\Repositories\Contracts\IAdmin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use function PHPUnit\Framework\isEmpty;

class AdminController extends Controller
{
    use HttpResponse;

    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request)//: \Illuminate\Http\Response
    {
        $query = User::query()->where(['is_admin' => 1]);
        if ($request->query('with_trashed')) {
            $query = $query->withTrashed($query);
        }
        if ($request->query('value')) {
            $query = $query->where(['email' => $request->query('value')]);
        }
        $admins = $query->paginate( $request->count);
        return self::returnData('admins', AdminResource::collection($admins), $admins);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRequest $request): \Illuminate\Http\Response
    {
        $data = $request->except('confirm_password');
        $data['is_admin'] = 1;
        $data['verified_at'] = now();
        $admin = User::query()->forceCreate($data);
        $admin->assignRole('admin');
        $admin->save();
        return self::success('Admin created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): \Illuminate\Http\Response
    {
        $admin = User::query()->findOrFail($id);
        return self::returnData('admins', new AdminResource($admin));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminRequest $request, string $id): \Illuminate\Http\Response
    {
        $data = $request->validated();
        $admin = User::query()->findOrFail($id);
        $admin->update( $data);
        return self::success('Admin updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): \Illuminate\Http\Response
    {
        $admin = User::query()->findOrFail($id);
        if ($admin->id == Auth()->user()->id) {
            return self::failure('You cannot delete your account!', 403);
        }
        $admin->delete($admin);
        return self::success('Admin deleted successfully!');
    }
    /**
     * return the specified resource from storage.
     */
    public function restore(string $id): \Illuminate\Http\Response
    {
        $admin = User::query()->withTrashed()->findOrFail($id);
        $admin->restore($id);
        return self::success('Admin restored successfully!');
    }
}
