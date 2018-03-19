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
    Route::post('register', 'AuthController@register')->name('register');
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('user', 'AuthController@user');
});



Route::prefix('v1')->namespace('Api\V1')->group(function() {
    Route::get('/recipes', 'RecipeController@index');
    Route::get('/recipes/{recipe}', 'RecipeController@show')->name('recipe.single');
    Route::post('/recipes/create', 'RecipeController@create');
 
    Route::get('/category/', 'TagController@index')->name('category');
    Route::get('/category/{category}', 'TagController@show')->name('category.show');
    

    Route::get('/shopping-list', 'ShoppingListController@get')->name('shopping-list');
    Route::post('/shopping-list/update', 'ShoppingListController@add')->name('shopping-list.update');

    # Search
    Route::post('search', 'SearchController@get')->name('search');
});