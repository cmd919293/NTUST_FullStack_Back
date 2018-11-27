<?php

use App\AttributeName;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AttributeName::truncate();
        $file = base_path('database\seeds\MonsterDB\attributename.csv');
		$file = str_replace('\\','/',$file);
        $query = "LOAD DATA INFILE '$file' INTO TABLE `attributename` CHARACTER SET UTF8 FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\n'";
        DB::connection()->getpdo()->exec($query);
    }
}
