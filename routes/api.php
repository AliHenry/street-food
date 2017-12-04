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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'App\Http\Controllers\StreetFood'], function (){

    Route::get('users', 'CustomerController@getUsers');

    Route::get('item/featured', 'ItemController@featuredItem');

    Route::get('item/search', 'ItemController@searchItem');

    Route::get('item', 'ItemController@allItem');

});
