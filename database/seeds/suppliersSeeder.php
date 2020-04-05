<?php

use Illuminate\Database\Seeder;
use App\suppliers;

class suppliersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        suppliers::insert([
            'name' => 'dostawca 1',
            'email' => 'ludek077@gmail.com',
            'phone' => 159159852,
        ]);

        suppliers::insert([
            'name' => 'dostawca 2',
            'email' => 'ludek088@gmail.com',
            'phone' => 123654789,
        ]);
    }
}
