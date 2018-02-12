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
