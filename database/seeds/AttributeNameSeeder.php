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
        AttributeName::query()->truncate();
        $file = base_path('database\seeds\MonsterDB\attributename.csv');
		$file = str_replace('\\','/',$file);
        $query = "LOAD DATA INFILE '$file' INTO TABLE `attributename` CHARACTER SET UTF8 FIELDS TERMINATED BY ',' ENCLOSED BY '\\\"' LINES TERMINATED BY '\\r\\n'";
        DB::connection()->getpdo()->exec($query);
    }
}
