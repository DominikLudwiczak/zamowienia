<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\orders;
use Faker\Generator as Faker;

$factory->define(orders::class, function (Faker $faker) use ($factory) {
    return [
        'order_id' => mt_rand(0000000000, 9999999999),
        'supplier_id' => $factory->create(App\suppliers::class)->id,
        'product_id' => $factory->create(App\products::class)->id,
        'ammount' => rand(pow(10,1), pow(10,2)-1),
        'user_id' => $factory->create(App\User::class)->id
    ];
});
