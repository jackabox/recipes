<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/recipes', function () {
    return factory('App\Models\Recipe', 10)->make();
});

Route::get('/recipe/{id}', function () {
    return factory('App\Models\Recipe', 1)->make()[0];
});

Route::get('/recipe/{id}/ingredients', function (Request $request) {
    $list = factory('App\Models\Recipe', 1)->make()[0];

    $ingredient = [];

    foreach ($list->ingredients as $key => $l) {
        $ingredient[] = [
            'amount' => ($l['amount'] / 1) * $request->input('qty'),
            'type' => $l['type']
        ];
    }

    return $ingredient;
});
