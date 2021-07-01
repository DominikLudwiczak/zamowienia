<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(suppliersSeeder::class);
        $this->call(productsSeeder::class);
        $this->call(ordersSeeder::class);
        $this->call(orderDetailsSeeder::class);
    }
}
