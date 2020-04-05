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
            return redirect()->back()->with('failed', $request->nazwa.' juz jest dodany do '.$supplier);
        }
    }


    public function edit($id)
    {
        $product = products::findOrFail($id);
        $suppliers = suppliers::all();
        return view('products.edit_product')->with('product', $product)->with('suppliers', $suppliers);
    }

    
    public function edit_product_save(Request $request, $id)
    {
        if(products::whereSupplier_id($request->dostawca)->whereName($request->nazwa)->first())
        {
            $supplier = suppliers::findOrFail($request->dostawca)->name;
            return redirect()->back()->with('failed', $request->nazwa.' juz jest dodany do '.$supplier);
        }
        try
        {
            $product = products::findOrFail($id);
            $product->name = $request->nazwa;
            $product->supplier_id = $request->dostawca;
            $product->save();
        }
        catch(\Illuminate\Database\QueryException $ex){
            return redirect(route('products'))->with('failed', 'Modyfikacja nie powiodła się');
        }
        return redirect(route('products'))->with('success', 'Zmodyfikowano produkt');
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
