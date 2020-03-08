<?php

use App\CashType;
use Illuminate\Database\Seeder;

class CashTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CashType::create([
            'type' => 'in',
            'description' => 'Umum',
        ]);
        CashType::create([
            'type' => 'out',
            'description' => 'Mikro',
        ]);
        CashType::create([
            'type' => 'out',
            'description' => 'Makro',
        ]);
        CashType::create([
            'type' => 'out',
            'description' => 'Zakat',
        ]);
    }
}
