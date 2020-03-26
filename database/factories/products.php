<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\products;
use Faker\Generator as Faker;

$factory->define(products::class, function (Faker $faker) use ($factory) {
    return [
        'supplier_id' => $factory->create(App\suppliers::class)->id,
        'name' => $faker->word
    ];
});
