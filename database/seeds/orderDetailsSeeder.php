<?php

use Illuminate\Database\Seeder;
use App\orderDetails;

class orderDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        orderDetails::insert([
            'order_id' => '1238526970',
            'product_id' => 1,
            'ammount' => 2
        ]);

        orderDetails::insert([
            'order_id' => '1238526970',
            'product_id' => 2,
            'ammount' => 5
        ]);

        orderDetails::insert([
            'order_id' => '2589631400',
            'product_id' => 4,
            'ammount' => 8
        ]);
    }
}
