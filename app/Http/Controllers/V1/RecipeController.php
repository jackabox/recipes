<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Recipe;

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

    public function show(Request $request, $id)
    {
        return response()->json(Recipe::find($id));
    }
}