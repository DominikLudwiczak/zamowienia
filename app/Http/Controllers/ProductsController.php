<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\products;
use App\suppliers;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function products()
    {
        $products = products::paginate(15);
        $suppliers = suppliers::all();
        for($i=0; $i < count($products); $i++)
            foreach($suppliers as $supplier)
                if($supplier->id == $products[$i]['supplier_id'])
                    $products[$i]['supplier_id'] = $supplier->name;
        return view('products.products')->with('products', $products);
    }
}
