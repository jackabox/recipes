<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Validator;
use App\Models\RecipeIngredient;
use Carbon\Carbon;
use App\Http\Resources\RecipeResource;

class RecipeController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth:api')->only(['create']);
    }

    public function index() 
    {
        $recipes = Recipe::with('media', 'user')->latest()->paginate(12);
        
        $recipes->each(function($recipe) {
            if ($recipe->getMedia()->count() > 0) {
                $recipe->media_url = $recipe->getMedia()[0]->getTemporaryUrl(Carbon::now()->addMinutes(10));
            }
        });
        
        // return response()->json($recipes);
        return RecipeResource::collection($recipes);
    }

    public function show(Request $request, Recipe $recipe)
    {
        $recipe->load('ingredients', 'media', 'user');

        if ($recipe->getMedia()->count() > 0) {
            $recipe->media_url = $recipe->getMedia()[0]->getTemporaryUrl(Carbon::now()->addMinutes(10));
        }

        return response()->json($recipe);
    }

    public function top(Request $request)
    {
        $recipes = Recipe::with('media', 'user')->latest()->take(3)->get();
        
        $recipes->each(function($recipe) {
            if ($recipe->getMedia()->count() > 0) {
                $recipe->media_url = $recipe->getMedia()[0]->getTemporaryUrl(Carbon::now()->addMinutes(10));
            }
        });

        return response()->json($recipes);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:1',
            'cook_time' => 'required|integer|min:0',
            'prep_time' => 'required|integer|min:0',
            'serves' => 'required|integer|min:1',
            'ingredients' => 'required|json',
            'method' => 'required|json',
            'image'  => 'image'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'validator failed',
                'response' => $validator->errors()
            ]);
        }

        $recipe = new Recipe();
        $recipe->title = $request->title;
        $recipe->description = $request->description;
        $recipe->cook_time = $request->cook_time;
        $recipe->prep_time = $request->prep_time;
        $recipe->user_id = auth()->id();
        $recipe->serves = $request->serves;
        $recipe->method = $request->method;
        $recipe->save();

        if ($request->image) {
            $recipe
                ->addMedia($request->image)
                ->toMediaCollection();
        }

        foreach (json_decode($request->ingredients) as $ingredient) {
            RecipeIngredient::create([
                'recipe_id' => $recipe->id,
                'title' => $ingredient->title,                
                'quantity' => $ingredient->quantity,
                'measurement' => $ingredient->measurement,
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'response' => $recipe
        ]);
    }
}