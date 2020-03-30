<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\products;
use App\suppliers;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }



    public function suppliers()
    {
        $suppliers = suppliers::orderBy('name')->paginate(15);
        return view('suppliers')->with('suppliers', $suppliers);
    }



    public function products()
    {
        $products = products::paginate(15);
        $suppliers = suppliers::all();
        for($i=0; $i < count($products); $i++)
            foreach($suppliers as $supplier)
                if($supplier->id == $products[$i]['supplier_id'])
                    $products[$i]['supplier_id'] = $supplier->name;
        return view('products')->with('products', $products);
    }
}