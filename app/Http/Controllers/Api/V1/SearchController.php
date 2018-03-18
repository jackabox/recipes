<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Models\Tag;

class SearchController extends Controller
{
    public function get(Request $request)
    {
        $search = Recipe::where('title', 'LIKE', '%' . $request->input('term') . '%')->get();

        $search->each(function($item) {
            $item->type = 'Recipe';
        });

        $tags = Tag::where('title', 'LIKE', '%' . $request->input('term') . '%')->get();

        $tags->each(function($item) {
            $item->type = 'category';
        });

        $ingredients = Recipe::where('ingredients->title', 'LIKE', '%' . $request->input('term') . '%')->take(10)->get();

        $ingredients->each(function($item) {
            $item->type = 'ingredient';
        });

        $search = $search->merge($tags)
                    ->merge($ingredients)
                    ->take(10);

        return response()->json($search);
    }
}
