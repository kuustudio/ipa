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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::group(['middleware' => 'check_token'], function () {
    Route::post('user', 'Api\ApiController@userinfo');
});

Route::post('mlogin', 'Api\ApiController@mlogin');
Route::post('tlogin', 'Api\ApiController@tlogin');
Route::post('logout', 'Api\ApiController@logout');
Route::post('getArea', 'Api\ApiController@getArea');


Route::post('apple/generatePackage','Api\AppleController@generatePackage')->name('generatePackage');