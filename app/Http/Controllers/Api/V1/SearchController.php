<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Models\Tag;
use App\Models\RecipeIngredient;

class SearchController extends Controller
{
    public function get(Request $request)
    {
        $search = Recipe::where('title', 'LIKE', '%' . $request->input('term') . '%')->get();
        $tags = Tag::where('title', 'LIKE', '%' . $request->input('term') . '%')->get();
        $ingredients = RecipeIngredient::where('title', 'LIKE', '%' . $request->input('term') . '%')->get();

        $tags->each(function($item) {
            $item->type = 'category';
        });

        $search->each(function($item) {
            $item->type = 'recipe';
        });

        $ingredients = $ingredients->unique('title');
        $ingredients->each(function($item) {
            $item->type = 'ingredient';
        });

        $search = $search->merge($tags);
        $search = $search->merge($ingredients);

        return response()->json($search->take(10));
    }
}
