<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\Category\IndexHomeResource;
use App\Http\Resources\User\Category\SelectedResource;
use App\Models\Category;
use App\Repositories\Contracts\ICategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{   
   

    ////////  home page category 
    public function index(){
         $categories = Category::with('media','translations')
            ->latest()
            ->paginate(4);  // latest 4 categories 
         return self::returnData('categories',IndexHomeResource::collection($categories));
    }

    /////// all category for select 
    public function allCategory(){
        $categories = Category::with('translation')->latest()->get();
        return self::returnData('categories',SelectedResource::collection($categories));
    }

    
}
