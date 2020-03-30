<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\suppliers;
use Faker\Generator as Faker;

$factory->define(suppliers::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'phone' => rand(pow(10,8), pow(10,9)-1)
    ];
});