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
        $names = [
            '花顏巧語優惠券',
            '低能專案',
            '陳尚付',
            '電風扇好冷優惠券',
            '新手大平台禮包'
        ];
        $initCount = rand(10, 20);
        while ($initCount--) {
            $year = sprintf("%04d", rand(2018, 2019));
            $mon = sprintf("%02d", rand(1, 12));
            $day = sprintf("%02d", rand(1, 28));
            $h = sprintf("%02d", rand(1, 23));
            $m = sprintf("%02d", rand(0, 59));
            $s = sprintf("%02d", rand(0, 59));
            Coupon::query()->create([
                'Name' => $names[rand(0,4)],
                'UserId' => 0,
                'OrderId' => 0,
                'Discount' => rand(2, 10) * 100,
                'Token' => hash('md5', rand(0,100000)),
                'expired_at' => "{$year}-{$mon}-{$day} {$h}:{$m}:{$s}",
                'Owned' => false,
                'Used' => false,
                'created_at' => '2017-11-20 00:00:00',
                'updated_at' => '2017-11-20 00:00:00'
            ]);
        }
    }
}
