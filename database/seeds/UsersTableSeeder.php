<?php

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'fauzie.rofi@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('fauzurrofi'),
            'role' => 'admin',
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name' => 'User',
            'username' => 'user',
            'email' => 'user@example.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('12345'),
            'role' => 'user',
            'remember_token' => Str::random(10),
        ]);
    }
}
