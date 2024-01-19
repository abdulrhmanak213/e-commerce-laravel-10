<?php

namespace App\Http\Controllers\Admin\Color;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Color\ColorRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\Admin\Color\ColorResource;
use App\Models\Color;
use App\Models\Product;
use App\Repositories\Contracts\IColor;
use Illuminate\Http\Request;

class ColorController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request): \Illuminate\Http\Response
    {
        $query = Color::query();
        if ($request->query('with_trashed')) {
            $query->onlyTrashed();
        }
        if ($request->query('value')) {
            $query->where(['name' => $request->query('value')]);
        }
        $colors = $query->paginate($request->count);
        return self::returnData('colors', ColorResource::collection($colors), $colors);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ColorRequest $request): \Illuminate\Http\Response
    {
        Color::query()->create(['name' => $request->name]);
        return self::success('Color added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $color = Color::query()->findOrFail($id);
        return self::returnData('color', new ColorResource($color));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ColorRequest $request, string $id)
    {
        $color = Color::query()->findOrFail($id);
        $color->update(['name' => $request->name]);
        return self::success('Color updated successfully!');
    }

    public function destroy(string $id)
    {
        $color = Color::query()->findOrFail($id);
        $color->delete($color);
        return self::success('Color deleted successfully!');
    }

    public function restore(string $id): \Illuminate\Http\Response
    {
        $color = Color::query()->withTrashed()->findOrFail($id);
        $color->restore($id);
        return self::success('Color restored successfully!');
    }
}
