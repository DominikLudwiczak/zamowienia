<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'nazwa' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phone,
    ];
});