<?php

namespace App\Http\Controllers\api;

use App\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     * ListCoupon
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $userId = Auth::user()->getAuthIdentifier();
        $coupons = Coupon::where('UserId','=', $userId)
            ->where('Used', '=', false)
            ->where('expired_at', '>=', date("Y-m-d H:i:s"))
            ->get();
        foreach ($coupons as $coupon) {
            if (!$coupon['Used']) {
                $data[$coupon['id']]['id'] = $coupon['id'];
                $data[$coupon['id']]['Name'] = $coupon['Name'];
                $data[$coupon['id']]['Discount'] = $coupon['Discount'];
                $data[$coupon['id']]['ExpiredAt'] = $coupon['expired_at']->format('Y-m-d H:i:s');
            }
        }
        return response()->json([
            'status' => true,
            'message' => [],
            'coupon' => array_values($data)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     * GetCoupon
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coupon_code' => 'required|string|min:32|max:40'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()
            ], 400);
        }
        $userId = Auth::user()->getAuthIdentifier();
        Coupon::query()
            ->where('Token', '=', $request['coupon_code'])
            ->update([
                'UserId' => $userId,
                'Owned' => true
            ]);
        return response()->json([
            'status' => true,
            'message' => []
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        //
    }
}
