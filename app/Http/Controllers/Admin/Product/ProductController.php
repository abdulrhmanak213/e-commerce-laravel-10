<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\ProductRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\Admin\Product\ProductIndexResource;
use App\Http\Resources\Admin\Product\ProductResource;
use App\Models\Product;
use App\Models\User;
use App\Repositories\Contracts\ICountry;
use App\Repositories\Contracts\IProduct;
use App\Repositories\Contracts\ISale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request): \Illuminate\Http\Response
    {
        $query = Product::query()->with(['media', 'translation']);
        if ($request->query('with_trashed')) {
            $query->onlyTrashed();
        }
        if ($request->query('value')) {
            $query->whereTranslationLike('name', 'like', '%' . $request->query('value') . '%');
        }
        $products = $query->paginate($request->count);
        return self::returnData('products', ProductIndexResource::collection($products), $products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $data = $request->only('price', 'quantity', 'category_id');
        $product = Product::query()->create($data);
        $product->productColors()->attach($request->color_ids);
        $this->addSizes($product, $request->sizes);
        $this->translate($product, $request->only('name_ar', 'name_en', 'description_ar', 'description_en'));
        $product->addMedia($request->cover)->toMediaCollection('product_cover');
        foreach ($request->images as $image) {
            $product->addMedia($image)->toMediaCollection('product_images');
        }
        return self::success('Product added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::query()->with(['media', 'translation', 'productSizes', 'productColors', 'category'])->findOrFail($id);
        return self::returnData('product', new ProductResource($product));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $product = Product::query()->findOrFail($id);
        $product->update($request->only('price', 'quantity', 'category_id', 'is_on_sale'));
        $this->translate($product, $request->only('name_ar', 'name_en', 'description_ar', 'description_en'));
        $product->productColors()->sync($request->color_ids);
        if ($request->exists('cover')) {
            $product->clearMediaCollection('product_cover');
            $product->addMedia($request->cover)->toMediaCollection('product_cover');
        }
        if ($request->exists('images')) {
            $product->clearMediaCollection('product_images');
            foreach ($request->images as $image) {
                $product->addMedia($image)->toMediaCollection('product_images');
            }
        }
        return self::success('Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::query()->findOrFail($id);
        $product->delete();
        return self::success('Product deleted successfully!');
    }

    public function restore(string $id): \Illuminate\Http\Response
    {
        $product = Product::query()->withTrashed()->findOrFail($id);
        $product->restore();
        return self::success('Product restored successfully!');
    }

    public function onSaleToggle(string $id)
    {
        $product = Product::query()->findOrFail($id);
        if ($product->is_on_sale) {
            $product->forceFill(['is_on_sale' => false])->save();
            return self::success('Product has been removed from sale successfully!');
        }
        $product->forceFill(['is_on_sale' => true])->save();
        return self::success('Product has been added from sale successfully!');
    }

    public function addSizes($record, $sizes)
    {
        $productSizes = [];
        foreach ($sizes as $size) {
            $productSizes[] = [
                'product_id' => $record->id,
                'size' => $size,
            ];
        }
        $record->productSizes()->createMany($productSizes);
    }

    public function translate($record, $data)
    {
        $translatedAttributes = ['name', 'description'];
        foreach ($this->languages as $language) {
            foreach ($translatedAttributes as $field)
                $record->translateOrNew($language)->$field = $data[$field . '_' . $language];
        }
        $record->save();
    }
}
