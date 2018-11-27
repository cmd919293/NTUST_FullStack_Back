<?php

use App\MonsterAttributes;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MonsterAttributesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MonsterAttributes::truncate();
        $file = base_path('database\seeds\MonsterDB\MonsterAttributes.csv');
		$file = str_replace('\\','/',$file);
        $query = "LOAD DATA INFILE '$file' INTO TABLE `MonsterAttributes` CHARACTER SET UTF8 FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\n'";
        DB::connection()->getpdo()->exec($query);
    }
}
