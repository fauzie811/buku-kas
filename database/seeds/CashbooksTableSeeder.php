<?php

use App\Cashbook;
use Illuminate\Database\Seeder;

class CashbooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cashbook::create([
            'name' => 'Kas Umum',
        ]);
        Cashbook::create([
            'name' => 'Bank Syariah Mandiri',
        ]);
        Cashbook::create([
            'name' => 'Bank BRI',
        ]);
        Cashbook::create([
            'name' => 'Bank BCA',
        ]);
    }
}
