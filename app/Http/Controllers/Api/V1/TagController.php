<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\Recipe;

class TagController extends Controller
{
    public function __construct() 
    {
        // $this->middleware('auth:api');
    }
    
    public function index() 
    {
        $categories = Tag::all();

        return response()->json($categories);
    }

    public function show(Tag $category)
    {
        $category_recipes = Recipe::whereHas('tags', function ($query) use ($category) {
            $query->where('tag_id', $category->id);
        })->latest()->paginate();

        return response()->json($category_recipes);
    }
}
