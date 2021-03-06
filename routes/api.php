<?php

use App\Http\Controllers\api\ImageController;
use App\Http\Controllers\api\MonsterController;
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

\Illuminate\Support\Facades\Log::info('Called API');
//Auth Route
Route::middleware('throttle:100,1')->group(function (){
    Route::post('register', 'api\AuthController@register');
    Route::post('login', 'api\AuthController@login');
    Route::post('forgetPwd', 'api\AuthController@forgetPwd');
    Route::post('reset', 'api\AuthController@resetPwd');
    Route::middleware('auth:api')->group(function () {
        Route::get('user', 'api\AuthController@me');
        Route::get('refresh', 'api\AuthController@refresh');
        Route::get('logout', 'api\AuthController@logout');
        Route::post('config', 'api\AuthController@edit');
        //Customer-Repl
        Route::post('customer-reply','api\CustomerReplyController@store');
    });
});
Route::middleware('throttle:500,1')->group(function () {
//AttributeName
    Route::get('GetAttributes', 'api\AttributeNameController@index');
//Monster Route
    Route::get('GetMonstersAmount/{fsStr?}', 'api\MonsterController@amount');
    Route::get('GetMonsters//{StartIndex}/{EndIndex}', function ($startId, $endId) {
        return app()->make(MonsterController::class)->show('*', $startId, $endId);
    });
    Route::prefix('GetMonsters')->group(function () {
        Route::get('{index}', function ($index) {
            return app(MonsterController::class)->show("id:$index");
        });
        Route::get('{StartIndex}/{EndIndex}', function ($startId, $endId) {
            return app(MonsterController::class)->show('*', $startId, $endId);
        });
        Route::get('{fsString?}/{StartIndex?}/{EndIndex?}', 'api\MonsterController@show')
            ->where(['StartIndex' => '[0-9]+', 'EndIndex' => '[0-9]+'])
            ->name('GetMonsters');
    });
    Route::middleware('admin')->group(function () {
        Route::post('CreateMonster', 'api\MonsterController@store');
        Route::post('UpdateMonster', 'api\MonsterController@update');
        Route::delete('DeleteMonster/{id}', 'api\MonsterController@destroy');
        Route::post('CreateAttribute', 'api\AttributeNameController@store');
        Route::post('UpdateAttribute', 'api\AttributeNameController@update');
        Route::delete('DeleteAttribute/{id}', 'api\AttributeNameController@destroy');
        Route::get('Shipment/{id}', 'api\OrderController@send');
    });
    Route::get('Search/{name}', 'api\MonsterController@search');
//Cart Route
    Route::middleware('auth:api')->group(function () {
        Route::get('GetCart', 'api\CartController@index');
        Route::get('GetOrders', 'api\OrderController@index');
        Route::post('UpdateCart', 'api\CartController@update');
        Route::post('MakeOrder', 'api\CartController@store');
    });
//Comment Route
    Route::get('GetComment', 'api\UserCommentController@show');
    Route::middleware('auth:api')->group(function () {
        Route::post('WriteComment', 'api\UserCommentController@store');
    });
//Coupon Route
    Route::middleware('auth:api')->group(function () {
        Route::get('ListCoupon', 'api\CouponController@index');
        Route::post('GetCoupon', 'api\CouponController@store');
    });
});
Route::middleware('throttle:1000,1')->group(function () {
    Route::get('GetCart', 'api\CartController@index');
    Route::get('GetOrders', 'api\OrderController@index');
    Route::post('UpdateCart', 'api\CartController@update');
    Route::post('MakeOrder', 'api\CartController@store');
//Image Route
    Route::prefix('Image')->middleware('throttle:1000')->group(function () {
        Route::get('{size}/{monId}/', function ($size, $monId) {
            return app()->make(ImageController::class)->show($size, $size, $monId, 0);
        })->where([
            'size' => '[0-9]+',
            'monId' => '[0-9]+',
        ]);
        Route::get('{size}/{monId}/{imgId}', function ($size, $monId, $imgId) {
            return app()->make(ImageController::class)->show($size, $size, $monId, $imgId);
        })->where([
            'size' => '[0-9]+',
            'monId' => '[0-9]+',
            'imgId' => '[0-9]+',
        ]);
        Route::get('{width}/{height}/{monId}/{imgId}', 'api\ImageController@show')->name('GetImage');
        Route::prefix('Base64')->group(function () {
            Route::get('{monId}', 'api\ImageController@ToBase64');
            Route::get('{monId}/{imgId}', 'api\ImageController@ToBase64');
        });
    });
});
//Test
