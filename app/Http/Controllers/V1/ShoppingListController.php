<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ShoppingList;
use Carbon\Carbon;

class ShoppingListController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth:api');
    }

    public function get(Request $request)
    {
        $list = ShoppingList::selectRaw('sum(quantity) as qty, ingredient, measurement')
            ->where('user_id', auth()->id())
            ->groupBy('ingredient', 'measurement')
            ->get();
    
        return response()->json($list);
    }

    public function add(Request $request)
    {
        $recipe_id = $request->input('recipe_id');
        $user_id = auth()->id();

        foreach ($request->input('ingredients') as $ingredient) {
            $item = new ShoppingList();
            $item->user_id = $user_id;
            $item->recipe_id = $recipe_id;
            $item->quantity = $ingredient['amount'];
            $item->measurement = $ingredient['measurement'];
            $item->ingredient = $ingredient['name'];
            $item->expires_on = Carbon::now()->addWeeks(2);
            $item->save();
        }
    
        return response()->json('List Updated');
    }

    public function delete(Request $request, $id)
    {
        return respoonse()->json('Delete Item Method');
    }
}
