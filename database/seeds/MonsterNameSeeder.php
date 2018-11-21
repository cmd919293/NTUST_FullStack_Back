<?php

use App\MonsterName;
use Illuminate\Database\Seeder;

class MonsterNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MonsterName::truncate();
        $file = base_path('database\seeds\MonsterDB\MonsterName.csv');
		$file = str_replace('\\','/',$file);
        $query = "LOAD DATA INFILE '$file' INTO TABLE `MonsterName` CHARACTER SET UTF8 FIELDS TERMINATED BY ',' ENCLOSED BY '\\\"' LINES TERMINATED BY '\\r\\n'";
        DB::connection()->getpdo()->exec($query);
    }
}
