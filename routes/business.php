<?php


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
Route::group(['namespace' => 'App\Http\Controllers\StreetFood\Business'], function (){

    Route::post('user', 'BusinessController@registerBizUser');

    Route::post('user/verify', 'BusinessController@verifyBizUser');

    Route::get('', 'BusinessController@getBusiness');

});

Route::group([
    'middleware' => 'user.roles',
    'roles' => 'Admin',
    'namespace' => 'App\Http\Controllers\StreetFood\Business'
], function (){

    Route::post('', 'BusinessController@createBusiness');

    Route::get('', 'BusinessController@getBizOwner');

    Route::post('category', 'BusinessController@createCategory');

    Route::put('category/{category_uuid}', 'BusinessController@updateCategory');

    Route::get('category', 'BusinessController@getCategories');

    Route::get('category/{category_uuid}', 'BusinessController@getCategory');

    Route::post('item', 'BusinessController@createItem');

    Route::put('item/{item_uuid}', 'BusinessController@updateItem');

    Route::get('item', 'BusinessController@getItems');

    Route::get('item/{item_uuid}', 'BusinessController@getItem');

});
