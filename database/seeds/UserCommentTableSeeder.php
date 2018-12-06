<?php
use App\UserComment;
use App\Monsters;
use App\User;
use Illuminate\Database\Seeder;

class UserCommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserComment::query()->truncate();
        $monIdArray = array_map(function ($v) {
            return $v['id'];
        }, Monsters::query()->select('id')->get()->toArray());
        $userIdArray = array_map(function ($v) {
            return $v['id'];
        }, User::query()->select('id')->get()->toArray());
        $initCount = rand(20, 50);
        while (count($userIdArray) && $initCount--) {
            $mon = sprintf("%02d", rand(1, 12));
            $day = sprintf("%02d", rand(1, 28));
            $h = sprintf("%02d", rand(1, 23));
            $m = sprintf("%02d", rand(0, 59));
            $s = sprintf("%02d", rand(0, 59));
            $comment = rand(10, 10000);
            UserComment::query()->create([
                'UserId' => $userIdArray[rand(0, count($userIdArray) - 1)],
                'ProductId' => $monIdArray[rand(0, count($monIdArray) - 1)],
                'Comment' => "{$comment}",
                'created_at' => "2018-{$mon}-{$day} {$h}:{$m}:{$s}",
                'updated_at' => "2018-{$mon}-{$day} {$h}:{$m}:{$s}"
            ]);
        }
    }
}
