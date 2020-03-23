<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) use ($factory) {
    return [
        'supplier_id' => $factory->create(App\suppliers::class)->id,
        'name' => $faker->name
    ];
});
