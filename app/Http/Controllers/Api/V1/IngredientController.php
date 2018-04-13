<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Models\RecipeIngredient;
use App\Http\Resources\RecipeResource;

class IngredientController extends Controller
{
    public function show(RecipeIngredient $ingredient)
    {
        $recipes = Recipe::whereHas('ingredients', function ($q) use ($ingredient) {
            $q->where('title', $ingredient->title);
        })->latest()->paginate(12);

        return RecipeResource::collection($recipes)->additional(['meta' => [
            'ingredient' => $ingredient->title,
        ]]);
    }
}
