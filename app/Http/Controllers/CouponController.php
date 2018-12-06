<?php

namespace App\Http\Controllers;

use App\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::orderBy('created_at', 'DESC')
            ->get();

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

        ]);

        $coupon->update($request->all());

        return redirect()->route('coupon.index');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('coupon.index');
    }
}
