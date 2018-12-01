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

//Auth Route
Route::middleware('throttle:60,1')->group(function () {
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
//AttributeName
    Route::get('GetAttributes', 'api\AttributeNameController@index');
//Monster Route
    Route::get('GetMonstersAmount/{fsStr}', 'api\MonsterController@amount');
    Route::get('GetMonsters//{StartIndex}/{EndIndex}', function ($startId, $endId) {
        return redirect()->route("GetMonsters", [
            'fsString' => '*',
            'StartIndex' => $startId,
            'EndIndex' => $endId,
        ]);
    });
    Route::prefix('GetMonsters')->group(function () {
        Route::get('{index}', function ($index) {
            return redirect()->route("GetMonsters", [
                'fsString' => "id:$index",
                'StartIndex' => 0,
                'EndIndex' => 0,
            ]);
        });
        Route::get('{StartIndex}/{EndIndex}', function ($startId, $endId) {
            return redirect()->route("GetMonsters", [
                'fsString' => '*',
                'StartIndex' => $startId,
                'EndIndex' => $endId,
            ]);
        });
        Route::get('{fsString?}/{StartIndex?}/{EndIndex?}', 'api\MonsterController@show')
            ->where(['StartIndex' => '[0-9]+', 'EndIndex' => '[0-9]+'])
            ->name('GetMonsters');
    });
    Route::middleware('admin')->group(function () {
        Route::post('CreateMonster', 'api\MonsterController@store');
    });
//Cart Route
    Route::middleware('auth:api')->group(function () {
        Route::get('GetCart', 'api\CartController@index');
        Route::get('GetOrders', 'api\OrderController@index');
        Route::post('UpdateCart', 'api\CartController@update');
        Route::post('MakeOrder', 'api\CartController@store');
    });
});
//Image Route
Route::prefix('Image')->middleware('throttle:1000')->group(function () {
    Route::get('{size}/{monId}/', function ($size, $monId) {
        return redirect()->route("GetImage", [
            'width' => $size,
            'height' => $size,
            'monId' => $monId,
            'imgId' => 0,
        ]);
    })->where(['size' => '[0-9]+']);
    Route::get('{size}/{monId}/{imgId}', function ($size, $monId, $imgId) {
        return redirect()->route("GetImage", [
            'width' => $size,
            'height' => $size,
            'monId' => $monId,
            'imgId' => $imgId,
        ]);
    });
    Route::get('{width}/{height}/{monId}/{imgId}', 'api\ImageController@show')->name('GetImage');
    Route::get('Base64/{monId}', 'api\ImageController@ToBase64');
});
//Test
Route::get('Search/{name}', 'api\MonsterController@search');
