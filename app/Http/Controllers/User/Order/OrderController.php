<?php

namespace App\Http\Controllers\User\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Cart\ShowCartRequest;
use App\Http\Resources\User\Order\CheckOutOrderResource;
use App\Http\Resources\User\Order\ShowResource;
use App\Http\Resources\User\Order\OrderResource;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Services\PriceService;


class OrderController extends Controller
{

    public function index()
    {
        $user = auth('user')->user();
        $orders = $user->orders()->latest()->paginate();
        $orders->load('invoice');
        $name = $user->first_name . ' ' . $user->last_name;
        return self::returnData(['user_name', 'user_email', 'orders'], [$name, $user->email, OrderResource::collection($orders)]);
    }

    public function show(Order $order)
    {
        // check user is same user_id in order
        $user = auth('user')->user();
        abort_if($user->id != $order->user_id,404);
        $order_products = OrderProduct::where('order_id', $order->id)
            ->with('product.media')
            ->get();
        return self::returnData('order_products', ShowResource::collection($order_products));
    }


    public function getOrder(Order $order, ShowCartRequest $request, PriceService $priceService)
    {
        $user = auth('user')->user();
        if ($user && ($user->id != $order->user_id && $request->s_id != $order->session_id)) {
            return self::failure('not authorize', 403);

        }
        elseif (!$user && $request->s_id != $order->session_id) {
            return self::failure('not authorize', 403);
        };
        $order->load(['orderProducts' => function ($query) {
            $query->with('product.media', 'product.translation');
        }, 'invoice']);
        $price_data = $priceService->getPrice();
        return self::returnData(
            ['user_name', 'order', 'currency', 'dolar_price'],
            [$user?->first_name, CheckOutOrderResource::make($order), $price_data['currency'], $price_data['exchange_rate']]);
    }
}
