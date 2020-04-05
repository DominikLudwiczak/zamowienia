<?php

use Illuminate\Database\Seeder;
use App\orders;

class ordersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        orders::insert([
            'order_id' => '1238526970',
            'supplier_id' => 1,
            'user_id' => 1
        ]);

        orders::insert([
            'order_id' => '2589631400',
            'supplier_id' => 2,
            'user_id' => 1
        ]);
    }
}
