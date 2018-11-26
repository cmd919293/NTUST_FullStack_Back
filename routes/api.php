<?php

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

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

Route::post('register', 'api\AuthController@register');
Route::post('login', 'api\AuthController@login');
Route::post('forgetPwd', 'api\AuthController@forgetPwd');
Route::post('reset', 'api\AuthController@resetPwd');
Route::middleware('auth:api')->group(function () {
    Route::get('user', 'api\AuthController@me');
    Route::get('refresh', 'api\AuthController@refresh');
    Route::get('logout', 'api\AuthController@logout');
    Route::post('config', 'api\AuthController@edit');
});

Route::get('GetMonsters//{StartIndex}/{EndIndex}', function ($startId, $endId) {
    return Redirect::to("GetMonsters/*/$startId/$endId");
});
Route::prefix('GetMonsters')->group(function () {
    Route::get('{index}', function ($index) {
        return Redirect::to("GetMonsters/id:$index/0/0");
    });
    Route::get('{StartIndex}/{EndIndex}', function ($startId, $endId) {
        return Redirect::to("GetMonsters/*/$startId/$endId");
    });
    Route::get('{fsString?}/{StartIndex?}/{EndIndex?}', 'api\MonsterController@show')
        ->where(['StartIndex' => '[0-9]+', 'EndIndex' => '[0-9]+'])
        ->name('GetMonsters');
});

Route::prefix('Image')->group(function () {
    Route::get('{size}/{monId}/', function ($size, $monId) {
        return Redirect::to("Image/$size/$size/$monId/0");
    });
    Route::get('{size}/{monId}/{imgId}', function ($size, $monId, $imgId) {
        return Redirect::to("Image/$size/$size/$monId/$imgId");
    });
    Route::get('{width}/{height}/{monId}/{imgId}', 'api\ImageController@show');
});

Route::middleware('auth:api')->group(function () {
    Route::get('GetCart', 'api\CartController@index');
    Route::post('UpdateCart', 'api\CartController@update');
    Route::post('MakeOrder', 'api\CartController@store');
    Route::get('GetOrders', 'api\OrderController@index');
});
