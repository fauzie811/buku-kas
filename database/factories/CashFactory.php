<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Cash;
use Faker\Generator as Faker;

$factory->define(Cash::class, function (Faker $faker) {
    return [
        'date' => $faker->dateTimeBetween('-1 years'),
        'cash_type_id' => $faker->numberBetween(1, 4),
        'description' => $faker->realText(30),
        'amount' => $faker->numberBetween(200, 3000) * 1000,
    ];
});
