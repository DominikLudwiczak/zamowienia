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
        if(!products::whereSupplier_id($request->dostawca)->whereName($request->nazwa)->first())
        {
            try
            {
                products::create($product);
            }catch(\Illuminate\Database\QueryException $ex){
                return redirect(route('products'))->with('failed', 'Wystąpił błąd podczas dodawania produktu');
            }
            return redirect(route('products'))->with('success', 'Dodano nowy produkt');
        }
        else
        {
            $supplier = suppliers::findOrfail($request->dostawca)->name;
            return redirect(route('products'))->with('failed', $request->nazwa.' juz jest dodany do '.$supplier);
        }
    }


    public function edit($id)
    {
        $product = products::findOrFail($id);
        return view('products.edit_product')->with('product', $product);
    }


    public function delete(Request $request)
    {
        try
        {
            products::findOrFail($request->id)->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect()->back()->with('failed', 'Wystąpił błąd podczas usuwania produktu');
        }
        return redirect()->back()->with('success', 'Produkt został usunięty');
    }
}
