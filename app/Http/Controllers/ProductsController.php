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
        $products = products::OrderBy('name')->paginate(15);
        $suppliers = suppliers::all();
        for($i=0; $i < count($products); $i++)
            foreach($suppliers as $supplier)
                if($supplier->id == $products[$i]['supplier_id'])
                    $products[$i]['supplier_id'] = $supplier->name;
        return view('products.products')->with('products', $products);
    }


    public function new_product()
    {
        $suppliers = suppliers::all();
        return view('products.new_product')->with('suppliers', $suppliers);
    }


    public function add_product(Request $request)
    {
        $product = [
            'supplier_id' => $request->dostawca,
            'name' => $request->nazwa,
        ];
        try
        {
            products::create($product);
        }catch(Exception $ex){
            return redirect(route('products'))->with('failed', 'Wystąpił błąd podczas dodawania produktu');
        }
        return redirect(route('products'))->with('success', 'Nowy produkt został dodany');
    }
}
