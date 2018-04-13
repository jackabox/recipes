<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Recipe;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\RecipeResource;

class CategoryController extends Controller
{
    public function __construct() 
    {
        // $this->middleware('auth:api');
    }
    
    public function index() 
    {
        $categories = Category::paginate(12);

        return CategoryResource::collection($categories);
    }

    public function all()
    {
        $categories = Category::orderBy('title', 'asc')->get();
        return response()->json($categories);
    }

    public function show(Category $category)
    {
        $recipes = Recipe::whereHas('categories', function ($query) use ($category) {
            $query->where('category_id', $category->id);
        })->latest()->paginate(12);


        return RecipeResource::collection($recipes)->additional(['meta' => [
            'category' => $category->title,
        ]]);
    }
}
