<?php

use App\Cash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class CashesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (App::environment('local')) {
            factory(Cash::class, 150)->create();
        }
    }
}
