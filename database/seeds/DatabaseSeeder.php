<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(MonsterSeeder::class);
        $this->call(AttributeNameSeeder::class);
        $this->call(MonsterAttributesSeeder::class);
        $this->call(MonsterNameSeeder::class);
        $this->call(CartSeeder::class);
    }
}
