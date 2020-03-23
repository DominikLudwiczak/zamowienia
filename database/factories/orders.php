<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'supplier_id' => $factory->create(App\suppliers::class)->id,
        'product_id' => $factory->create(App\products::class)->id,
        'user_id' => $factory->create(App\users::class)->id
    ];
});
