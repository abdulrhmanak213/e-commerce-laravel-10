<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Order\ChangeOrderStatusRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\Admin\Order\OrderIndexResource;
use App\Http\Resources\Admin\Order\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(SearchRequest $request): \Illuminate\Http\Response
    {
        $query = Order::query();
        if ($request->value) {
            $query = $query->where(['first_name' => $request->value]);
        }
        $orders = $query->paginate($request->count);
        return self::returnData('orders', OrderIndexResource::collection($orders), $orders);
    }

    public function show($id): \Illuminate\Http\Response
    {
        $order = Order::with(['orderProducts.product' => function ($query) {
            $query->withTrashed();
        }])->findOrFail($id);
        return self::returnData('order', OrderResource::make($order));
    }

    public function changeOrderStatus(ChangeOrderStatusRequest $request, $id): \Illuminate\Http\Response
    {
        $order = Order::query()->findOrFail($id);
        $order->forceFill( ['status' => $request->status])->save();
        return self::success('Status changed successfully!');
    }
}
