<?php

namespace App\Http\Controllers\api;

use App\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()) {
            $userId = Auth::user()->getAuthIdentifier();
            $result = Cart::query()->select(['ProductId', 'Count'])
                ->where('UserId', $userId)
                ->get();
            return response([
                    'status' => true,
                    'cart' => $result]
                , 200);
        } else {
            return response([
                'status' => false,
                'cart' => []],
                403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function test()
    {
        $userId = Auth::user()->getAuthIdentifier();
        return response(Cart::query()->select(['ProductId', 'Count'])->where('UserId', $userId)->get(), 200);
    }
}
