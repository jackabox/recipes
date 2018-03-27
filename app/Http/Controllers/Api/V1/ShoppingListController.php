<?php

namespace App\Http\Controllers\Api\V1;

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

    public function get()
    {
        $list = ShoppingList::selectRaw('sum(quantity) as qty, ingredient, measurement, bought')
            ->where('user_id', auth()->id())
            ->groupBy('ingredient', 'measurement', 'bought')
            ->get();
    
        return response()->json($list);
    }

    public function update(Request $request)
    {
        $recipe_id = $request->input('recipe_id');
        $user_id = auth()->id();

        foreach ($request->input('ingredients') as $ingredient) {
            $item = new ShoppingList();
            $item->user_id = $user_id;
            $item->recipe_id = $recipe_id;
            $item->quantity = $ingredient['quantity'];
            $item->measurement = $ingredient['measurement'];
            $item->ingredient = $ingredient['title'];
            $item->expires_on = Carbon::now()->addWeeks(2);
            $item->bought = 0;
            $item->save();
        }
    
        return $this->get();
    }

    public function deleteItem(Request $request)
    {
        $items = ShoppingList::where('user_id', auth()->id())->where('ingredient', $request->ingredient)->delete();
        
        return response()->json('Item Deleted');
        
    }

    public function changeItem(Request $request)
    {
        $items = ShoppingList::where('user_id', auth()->id())->where('ingredient', $request->ingredient)->update(['bought' => $request->status]);
        return response()->json('Item Updated');
    }
}
