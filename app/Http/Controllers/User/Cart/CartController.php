<?php

namespace App\Http\Controllers\User\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Cart\addProductRequest;
use App\Http\Requests\User\Cart\removeProductRequest;
use App\Http\Requests\User\Cart\ShowCartRequest;
use App\Http\Requests\User\Order\CheckOutRequest;
use App\Http\Resources\User\Cart\CartResource;
use App\Jobs\SendInvoiceMailJob;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\City;
use App\Models\Color;
use App\Models\Country;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductSize;
use App\Repositories\Contracts\ICart;
use App\Repositories\Contracts\ICartProduct;
use App\Repositories\Contracts\IInvoice;
use App\Repositories\Contracts\IOrder;
use App\Repositories\Contracts\ISale;
use App\Services\PriceService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;


class CartController extends Controller
{
    private $priceService ;

    public function __construct(PriceService $priceService)
    {
        $this->priceService = $priceService ;
    }

    public function show(ShowCartRequest $request) //: \Illuminate\Http\Response
    {
        $data = $request->validated();
        $user = $request->user('user');

        // get cart for user or create new
        $cart = $this->getCart($user, $data); 

        // check form city for shipment fees
        if ($request->has('city_id')) {   
            $city = City::find($request->city_id);
            $cart['shipment_fees'] = $city->shipment_fees;
        }

        $cart = $this->getCartData($cart);

        $price_data = $this->priceService->getPrice();

        return self::returnData(['cart', 'currency', 'dolar_price'], [new CartResource($cart), $price_data['currency'], $price_data['exchange_rate']]);
    }


    public function addProduct(Product $product, addProductRequest $request) //: \Illuminate\Http\Response
    {
        $data = $request->validated();

        $user = $request->user('user');
        $cart = $this->getCart($user, $data);
        $color = Color::findOrFail($request->color);
        $size = ProductSize::findOrFail($request->size);

        $product_cart = CartProduct::firstOrNew([
            'product_id' => $product->id,
            'cart_id' => $cart->id,
            'color' => $color->name,
            'size' => $size->size,
        ]);

        // if ($product->quantity < $data['quantity']) {
        //     return self::failure('wrong quantity!', 400);
        // }

        $product_cart->quantity += $data['quantity'];
        $product_cart->save();
        return self::success(__('messages.add_cart'));
    }

    public function increaseProduct(Product $product, removeProductRequest $request) //: \Illuminate\Http\Response
    {

        $data = $request->validated();
        $user = $request->user('user');
        $cart = $this->getCart($user, $data);

        $product_cart = CartProduct::query()->product($product, $cart, $data['color'], $data['size'])->firstOrFail();
        if (!$product_cart) {
            return self::failure('Product not found in cart', 400);
        }
        $product_cart->increment('quantity');
        $product_cart->save();
        return self::success(__('messages.edit_product_count'));
    }

    public function removeProduct(Product $product, removeProductRequest $request)
    {
        $data = $request->validated();
        $user = $request->user('user');
        $cart = $this->getCart($user, $data);

        $product_cart = CartProduct::query()->product($product, $cart, $data['color'], $data['size'])->firstOrFail();
        if (!$product_cart) {
            return self::failure('Product not found in cart', 400);
        }
        $product_cart->delete();
        return self::success(__('messages.remove_product_cart'));
    }


    public function decreaseProduct(Product $product, removeProductRequest $request): \Illuminate\Http\Response
    {
        $data = $request->validated();
        $user = $request->user('user');
        $cart = $this->getCart($user, $data);


        $product_cart = CartProduct::query()->product($product, $cart, $data['color'], $data['size'])->firstOrFail();
        if (!$product_cart) {
            return self::failure('Product not found in cart', 400);
        }
        if ($product_cart->quantity > 1) {
            $product_cart->quantity--;
            $product_cart->save();
        }
        else {
            $product_cart->delete();
        }
        return self::success(__('messages.edit_product_count'));
    }


    public function getCartData($cart)
    {
        $cart['invoice_value'] = 0;
        $cart['cart_products'] = CartProduct::where('cart_id', $cart->id)->withWhereHas('product', function ($query) {
            $query->with('media', 'translations');
        })->get();

        foreach ($cart['cart_products'] as $cart_product) {
            $price = $cart_product->product->price;

            // check from product is on sale 
            if ($cart_product->product->is_on_sale) {
                $sale =$this->priceService->getSaleValue();
                $cart['invoice_value'] += $cart_product->quantity * ($price - (($price * $sale?->value) / 100));
            }
            else

                $cart['invoice_value'] += $cart_product->quantity * $price;
        }
        $cart['total'] = $cart['invoice_value'] + $cart['shipment_fees'];
        return $cart;
    }


    public function getCart($user, $data)  
    {
        if ($user) {
            $cart = Cart::query()->with('cart_products.product')->firstOrCreate(['user_id' => $user->id]);
        }
        elseif (array_key_exists('s_id', $data)) {
            $cart = Cart::query()->with('cart_products.product')->firstOrCreate(['session_id' => $data['s_id']]);
        }
        return $cart;
    }


    public function checkOut(CheckOutRequest $request) 
    {
        try {
            //TODO: GET THE MONEY FROM STRIP ACCOUNT
            DB::beginTransaction();
            $user = auth('user')->user();
            //CREATING THE ORDER

            $cart = Cart::query()->with('cart_products.product')->where('id', $request->cart_id)->firstOrFail();

            // check from auth user is the owner or session id same s_id in order   
            if ($user && ($user->id != $cart->user_id && $request->s_id != $cart->session_id)) {
                throw new Exception('not authorize', 403);

            }
            elseif (!$user && $request->s_id != $cart->session_id) {
                throw new Exception('not authorize', 403);
            }


            $country = Country::query()->findOrFail($request->country_id);
            $city = City::query()->findOrFail($request->city_id);
            $cart['shipment_fees'] = $city->shipment_fees;


            $order = $this->createOrder($user, $country, $city, $request);

            //GETTING THE CART
            $cart = $this->getCartData($cart);
            $cart_products = $cart->cart_products;

            //CHECKING THE PRODUCTS QUANTITIES
            $order_products = array();
            foreach ($cart_products as $cart_product) {
                $product_instance = Product::query()->findOrFail($cart_product['product_id']);
                // if ($cart_product['quantity'] > $product_instance->quantity) {
                //     return self::failure('wrong quantity!', 400);
                // }
                //ADDING THE PRODUCTS TO ORDER_PRODUCTS TABLE
                $order_products[] = [
                    'product_id' => $product_instance->id,
                    'price' => $product_instance->price,
                    'quantity' => $cart_product['quantity'],
                    'color' => $cart_product['color'],
                    'size' => $cart_product['size'],
                    'order_id' => $order->id
                ];

                //DECREASE THE QUANTITY FOR PRODUCT
                // $product_instance->quantity -= $cart_product['quantity'];
                $product_instance->save();
            }
            OrderProduct::insert($order_products);

            //CREATE NEW INVOICE
            $invoice = $this->createOrderInvoice($user, $order->id, $cart);

            //DELETE THE CART
            $cart->delete();
            SendInvoiceMailJob::dispatch($invoice, $order, $user);
            DB::commit();
            return self::returnData('order_id', $order->id, null, __('messages.create_order'));
        }
        catch (\Exception $e) {
            DB::rollBack();
            return self::failure($e->getMessage(), 400);
        }
    }


    private function createOrder($user, $country, $city, $request)
    {  // creating order
        $order = Order::create([
            'user_id' => $user != null ? $user->id : null,
            'note' => $request->note,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $country->name . '/ ' . $city->name . '/ ' . $request->state . '/ ' . $request->street,
            'phone' => $request->phone,
            'email' => $request->email,
            'session_id' => $request->s_id
        ]);
        $order->order_id = 'AZL_' . substr(Carbon::now()->year, -2) . '0000' . $order->id;
        $order->save();
        return $order;
    }


    private function createOrderInvoice($user, $order_id, $cart)
    {
        return $invoice = Invoice::create([
            'user_id' => $user != null ? $user->id : null,
            'order_id' => $order_id,
            'invoice_value' => $cart['invoice_value'],
            'shipment_fees' => $cart['shipment_fees'],
            'total' => $cart['total'],
            'currency' => config('app.location') == 'Syria' ? 'SY' : '$'
        ]);
    }

  
}

//
