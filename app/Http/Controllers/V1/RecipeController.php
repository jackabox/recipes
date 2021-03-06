<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Validator;

class RecipeController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth:api');
    }

    public function index() 
    {
        return response()->json(Recipe::latest()->paginate());
    }

    public function show(Request $request, Recipe $recipe)
    {
        return response()->json($recipe);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:1',
            'description' => 'required|min:10',
            'cook_time' => 'required|integer|min:0',
            'prep_time' => 'required|integer|min:0',
            'serves' => 'required|integer|min:1',
            'ingredients' => 'required|array',
            'method' => 'required|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'validator failed'
            ]);
        }


        $recipe = new Recipe();
        $recipe->title = $request->title;
        $recipe->description = $request->description;
        $recipe->cook_time = $request->cook_time;
        $recipe->prep_time = $request->prep_time;
        $recipe->user_id = auth()->id();
        // $recipe->serves = $request->serves;
        $recipe->ingredients = json_encode($request->ingredients);
        $recipe->method = json_encode($request->method);
        $recipe->save();

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'response' => $recipe
        ]);
    }
}