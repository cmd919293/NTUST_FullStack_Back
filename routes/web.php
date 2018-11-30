<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\api\AttributeNameController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/create', function () {
    $data = app(AttributeNameController::class)->index();
    $data = json_decode(json_encode($data), true);
    return view('create', ['attrs' => $data['original']]);
})->name('create');

//Image Route
Route::prefix('Image')->group(function () {
    Route::get('{size}/{monId}/', function ($size, $monId) {
        return redirect()->route("GetImage", [
            'width' => $size,
            'height' => $size,
            'monId' => $monId,
            'imgId' => 0,
        ]);
    });
    Route::get('{size}/{monId}/{imgId}', function ($size, $monId, $imgId) {
        return redirect()->route("GetImage", [
            'width' => $size,
            'height' => $size,
            'monId' => $monId,
            'imgId' => $imgId,
        ]);
    });
    Route::get('{width}/{height}/{monId}/{imgId}', 'api\ImageController@show')
        ->name('GetImage');
});
