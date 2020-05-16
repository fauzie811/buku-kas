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
        $this->call(UsersTableSeeder::class);
        $this->call(CashbooksTableSeeder::class);
        $this->call(CashTypesTableSeeder::class);
        $this->call(CashesTableSeeder::class);
    }
}
