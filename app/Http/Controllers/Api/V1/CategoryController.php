<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Recipe;

class CategoryController extends Controller
{
    public function __construct() 
    {
        // $this->middleware('auth:api');
    }
    
    public function index() 
    {
        $categories = Category::paginate(10);

        return response()->json($categories);
    }

    public function all()
    {
        $categories = Category::orderBy('title', 'asc')->get();
        return response()->json($categories);
    }

    public function show(Category $category)
    {
        $category_recipes = Recipe::whereHas('categories', function ($query) use ($category) {
            $query->where('category_id', $category->id);
        })->latest()->paginate(12);

        $data = [
            'name' => $category->title,
            'recipes' => $category_recipes
        ];

        return response()->json($data);
    }
}
