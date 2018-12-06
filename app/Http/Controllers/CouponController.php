<?php

namespace App\Http\Controllers;

use App\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::orderBy('created_at', 'DESC')->paginate(10);

        $data = [
            'coupons' => $coupons
        ];

        return view('coupons.index', $data);
    }

    public function edit(Coupon $coupon)
    {
        $data = [
            'coupon' => $coupon
        ];

        return view('coupons.edit', $data);
    }

    public function update(Request $request, Coupon $coupon)
    {
        $this->validate($request, [
            'Name' => 'required|string|max:12',
            'UserId' => 'required|integer',
            'OrderId' => 'required|integer',
            'Discount' => 'required|integer',
            'Token' => 'required|string|min:32|max:40',
            'expired_at' => 'required|date_format:Y-m-d\TH:i',
            'Owned' => 'required|boolean',
            'Used' => 'required|boolean'
        ]);

        $request['expired_at'] = date('Y-m-d H:i:s', strtotime($request['expired_at']));

        $coupon->update($request->all());

        return redirect()->route('coupon.index');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('coupon.index');
    }
}
