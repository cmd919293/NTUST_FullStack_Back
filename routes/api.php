<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('GetMonsters//{StartIndex}/{EndIndex}', function ($startId, $endId) {
    return Redirect::to("GetMonsters/*/$startId/$endId");
});
Route::prefix('GetMonsters')->group(function () {
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
