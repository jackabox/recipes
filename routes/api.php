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
    Route::get('/recipes/top', 'RecipeController@top')->name('recipes.top');
    Route::get('/recipes/{recipe}', 'RecipeController@show')->name('recipe.single');
    Route::post('/recipes/create', 'RecipeController@create');
 
    # Categories
    Route::get('/category/', 'CategoryController@index')->name('category');
    Route::get('/category/all', 'CategoryController@all')->name('category.all');
    Route::get('/category/{category}', 'CategoryController@show')->name('category.show');

    # Ingredients
    Route::get('/ingredients/{ingredient}', 'IngredientController@show')->name('ingredients.show');
    
    # Shopping List
    Route::get('/shopping-list', 'ShoppingListController@get')->name('shopping-list');
    Route::post('/shopping-list/update', 'ShoppingListController@update')->name('shopping-list.update');
    Route::patch('/shopping-list/item/update', 'ShoppingListController@changeItem')->name('shopping-list.item.update');
    Route::delete('/shopping-list/item/delete', 'ShoppingListController@deleteItem')->name('shopping-list.item.delete');

    # Search
    Route::post('search', 'SearchController@get')->name('search');

    # Profile
    Route::get('profile/{user}', 'ProfileController@show')->name('profile');

    # Settings
    Route::get('settings', 'SettingsController@index')->name('settings');
    Route::post('settings/update/basic', 'SettingsController@updateBasicInfo')->name('settings.update.basic');
    Route::patch('settings/update/email', 'SettingsController@updateEmail')->name('settings.update.email');
    Route::patch('settings/update/password', 'SettingsController@updatePassword')->name('settings.update.password'); 
});