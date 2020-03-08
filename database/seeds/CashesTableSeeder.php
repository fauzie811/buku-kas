<?php

use App\Cash;
use Illuminate\Database\Seeder;

class CashesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Cash::class, 150)->create();
    }
}
