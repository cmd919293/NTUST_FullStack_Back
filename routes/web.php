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
use App\Http\Controllers\api\MonsterController;
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
Route::get('/{id}/edit', function ($id) {
    $data = app(AttributeNameController::class)->index();
    $data = json_decode(json_encode($data), true);
    dd($data);
    $mon = app(MonsterController::class)->show("id:$id");
    $mon = json_decode(json_encode($mon), true);
    return view('edit', ['attrs' => $data['original'], 'monster' => $mon['original']]);
})->name('edit');
