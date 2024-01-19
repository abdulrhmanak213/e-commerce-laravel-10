<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\Color\IndexResource as ColorIndexResource;
use App\Http\Resources\User\Product\IndexResource;
use App\Http\Resources\User\Product\ProductResource;
use App\Models\Color;
use App\Models\Currency;
use App\Models\Product;
use App\Services\PriceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Sale;
use App\Services\FilterService;

class ProductController extends Controller
{


    public function getAll(Request $request ,PriceService $priceService ,FilterService $filterService)
    {

        $price = explode(',',$request->price);
        $query = Product::query();
        $filters = [
            ['price', 'field', $price, 'whereBetween'],
            ['productColors', 'relation', $request->productColors, 'where','colors.id'],
            ['productSizes', 'relation', $request->productSizes, 'where','size'],
            ['category_id', 'field', $request->category_id, 'where'],
            ['name', 'field', $request->name, 'whereTranslationLike']
        ];
        foreach ($filters as $filter) {        // get product with filter by user request
            if (request()->has($filter[0])) {
                $query = $filterService->filters($query, ...$filter);
            }
        }
        $products = $query->latest()->paginate();

        $max_product_price = Product::max('price');      // this value for filter range
        $min_product_price = Product::min('price');
        $price_data = $priceService->getPrice();    // get exchange_rate and exchange_rate from service

        $sale = Cache::rememberForever('sale', function () {
            return Sale::query()->first();
        });
        /// use eloquent
        return self::returnData(['products' ,'max_price' ,'min_price','currency','dolar_price'],
            [IndexResource::collection($products) ,$max_product_price , $min_product_price ,$price_data['currency'] ,$price_data['exchange_rate']], $products);
    }


    public function getSimilar($id)
    {
        $product = Product::query()->with(['productColors'])->findOrFail($id);
        $similar_product = Product::query()
            ->where('id', '<>', $id) // Exclude the original product
            ->with([
                'translations',
                'media'
            ])
            ->withWhereHas(
                'productColors',
                function ($query) use ($product) {
                    $query->whereIn('colors.id', $product->productColors->pluck('id'));
                })
            ->withWhereHas(
                'category',
                function ($query) use ($product) {
                    $query->where('id', $product->category_id);
                })
            ->take(4)->get();
        return self::returnData('similar_products', IndexResource::collection($similar_product));

    }

    public function show(Product $product)
    {
        $product = $product->load(['productColors', 'productSizes', 'category']);
        return self::returnData('product', ProductResource::make($product));
    }


    public function allColor()
    {
        $colors = Color::latest()->get();
        return self::returnData('colors', ColorIndexResource::collection($colors));
    }

}
