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

Route::Auth();

Route::middleware('admin')->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/create', function () {
        $data = app(AttributeNameController::class)->index();
        $data = json_decode(json_encode($data), true);
        return view('create', ['attrs' => $data['original']]);
    })->name('create');

    Route::get('/{id}/edit', function ($id) {
        $data = app(AttributeNameController::class)->index();
        $data = json_decode(json_encode($data), true);
        $mon = app(MonsterController::class)->show("id:$id");
        $mon = json_decode(json_encode($mon), true);
        return view('edit', ['attrs' => $data['original'], 'monster' => $mon[0]]);
    })->name('edit');

    Route::prefix('Attribute')->group(function () {
        Route::get('/', 'HomeController@attr')->name('attribute');
        Route::get('create', function () {
            return view('createAttribute');
        });
        Route::get('{id}/edit', function ($id) {
            $attr = app(AttributeNameController::class)->show($id);
            return view('editAttribute', ['attribute' => $attr]);
        });
    });
    Route::get('OrderList', 'api\OrderController@getAll');

    Route::prefix('customer-reply')->group(function () {
        Route::get('','CustomerReplyController@index')->name('customer-reply.index');
        Route::get('{customerReply}/reply','CustomerReplyController@reply')->name('customer-reply.reply');
        Route::patch('{customerReply}','CustomerReplyController@update')->name('customer-reply.update');
    });

    Route::prefix('Coupon')->group(function () {
        Route::get('', 'CouponController@index')->name('coupon.index');
        Route::get('create', 'CouponController@create')->name('coupon.create');
        Route::post('', 'CouponController@store')->name('coupon.store');
        Route::get('{coupon}/edit', 'CouponController@edit')->name('coupon.edit');
        Route::patch('{coupon}', 'CouponController@update')->name('coupon.update');
        Route::delete('{coupon}', 'CouponController@destroy')->name('coupon.destroy');
    });

});


Route::prefix('customer-reply')->middleware('auth')->group(function () {
    Route::get('read/{customerReply}', 'CustomerReplyController@read')->name('customer-reply.read');
    Route::get('redirect/{customerReply}','CustomerReplyController@redirect')->name('customer-reply.redirect');
});
