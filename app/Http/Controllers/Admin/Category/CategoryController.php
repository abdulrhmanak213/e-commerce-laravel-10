<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\CategoryRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\Admin\Categry\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request): \Illuminate\Http\Response
    {
        $query = Category::query();
        if ($request->query('with_trashed')) {
            $query->onlyTrashed();
        }
        $categories = $query->paginate($request->count);
        return self::returnData('categories', CategoryResource::collection($categories), $categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): \Illuminate\Http\Response
    {
        $category = Category::query()->create([]);
        $this->translate($category, $request->except('image'));
        $category->addMedia($request->image)->toMediaCollection('category_image');
        $category->save();
        return self::success('Category added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): \Illuminate\Http\Response
    {
        $category = Category::query()->findOrFail($id);
        return self::returnData('category', new CategoryResource($category));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $category = Category::query()->findOrFail($id);
        $this->translate($category, $request->except('image'));
        if ($request->has('image')) {
            $category->clearMediaCollection('category_image');
            $category->addMedia($request->image)->toMediaCollection('category_image');
        }
        return self::success('Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::query()->findOrFail($id);
        $category->delete($category);
        return self::success('Category deleted successfully!');
    }

    public function restore(string $id): \Illuminate\Http\Response
    {
        $category = Category::query()->withTrashed()->findOrFail($id);
        $category->restore($id);
        return self::success('Category restored successfully!');
    }

    public function translate($record, $data)
    {
        foreach ($this->languages as $language) {
            $record->translateOrNew($language)->title = $data['title_' . $language];
        }
        $record->save();
    }
}
