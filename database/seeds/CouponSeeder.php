<?php

use App\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coupon::query()->truncate();
//        $monIdArray = array_map(function ($v) {
//            return $v['id'];
//        }, Monsters::query()->select('id')->get()->toArray());
//        $userIdArray = array_map(function ($v) {
//            return $v['id'];
//        }, User::query()->select('id')->get()->toArray());
//        $initCount = rand(2, 10);
//        while (count($userIdArray) && $initCount--) {
//            Cart::query()->create([
//                'UserId' => $userIdArray[rand(0, count($userIdArray) - 1)],
//                'ProductId' => $monIdArray[rand(0, count($monIdArray) - 1)],
//                'Count' => rand(10, 100),
//                'created_at' => '2018-11-20 00:00:00',
//                'updated_at' => '2018-11-20 00:00:00'
//            ]);
//        }
    }
}
