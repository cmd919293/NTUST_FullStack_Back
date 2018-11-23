<?php

use App\Monsters;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MonsterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Monsters::truncate();
        $file = base_path('database\seeds\MonsterDB\monster.csv');
        $file = str_replace('\\','/',$file);
        $query = "LOAD DATA INFILE '$file' INTO TABLE `Monsters` CHARACTER SET UTF8 FIELDS TERMINATED BY ',' ENCLOSED BY '\\\"' LINES TERMINATED BY '\\r\\n'";
        DB::connection()->getpdo()->exec($query);
    }
}
