<?php

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Session\Session;

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

/** 
 * AUTH
 */

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('user', 'AuthController@me');
});

Route::prefix('v1')->namespace('V1')->group(function() {
    Route::get('/recipes', 'RecipeController@index');
    Route::get('/recipes/{recipe}', 'RecipeController@show');
    Route::post('/recipes/create', 'RecipeController@create');
 
    Route::get('/shopping-list', 'ShoppingListController@get');
    Route::post('/shopping-list/update', 'ShoppingListController@add');
});




