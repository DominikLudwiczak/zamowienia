<?php

use Illuminate\Database\Seeder;
use App\products;

class productsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        products::insert([
            'supplier_id' => 1,
            'name' => 'produkt 1',
        ]);

        products::insert([
            'supplier_id' => 1,
            'name' => 'produkt 2',
        ]);

        products::insert([
            'supplier_id' => 2,
            'name' => 'produkt 3',
        ]);

        products::insert([
            'supplier_id' => 2,
            'name' => 'produkt 4',
        ]);
    }
}
