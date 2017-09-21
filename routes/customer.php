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
Route::group(['namespace' => 'App\Http\Controllers\StreetFood'], function (){

    Route::post('register-customer', 'CustomerController@registerCustomer');

    Route::post('verify-customer', 'CustomerController@verifyCustomer');
//
    Route::post('login', 'CustomerController@loginCustomer');
//
//    Route::post('update-customer', 'CustomerController@updateCustomer');
//
//    Route::post('create-customer-address', 'CustomerController@createAddress');
//
//    Route::post('update-customer-address', 'CustomerController@updateAddress');
//
//    Route::post('customer-details', 'CustomerController@getCustomerDetail');

});
