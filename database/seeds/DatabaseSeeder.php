<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->call(MonsterSeeder::class);
        $this->call(AttributeNameSeeder::class);
        $this->call(MonsterAttributesSeeder::class);
        $this->call(MonsterNameSeeder::class);
        $this->call(CartSeeder::class);
        $this->call(UserCommentTableSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
