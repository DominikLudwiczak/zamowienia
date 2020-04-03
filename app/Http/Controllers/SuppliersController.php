<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\products;
use App\suppliers;

class SuppliersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    

    public function suppliers()
    {
        $suppliers = suppliers::orderBy('name')->paginate(15);
        return view('suppliers.suppliers')->with('suppliers', $suppliers);
    }


    public function add_supplier(Request $request)
    {
        $supplier = [
            'name' => $request->nazwa,
            'email' => $request->email,
            'phone' => $request->telefon
        ];

        if(!suppliers::whereName($request->nazwa)->first())
        {
            try
            {
                suppliers::create($supplier);
            }catch(\Illuminate\Database\QueryException $ex){
                return redirect(route('suppliers'))->with('failed', 'Wystapił błąd podczas dodawania dostawcy');
            }
            return redirect(route('suppliers'))->with('success', 'Dodano nowego dostawcę');
        }
        return redirect(route('suppliers'))->with('failed', 'dostawca '.$request->nazwa.' juz istnieje');
    }


    public function edit($id)
    {
        $supplier = suppliers::findOrFail($id);
        return view('suppliers.edit_supplier')->with('supplier', $supplier);
    }


    public function delete(Request $request)
    {
        try
        {
            products::whereSupplier_id($request->id)->delete();
            suppliers::findOrFail($request->id)->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect()->back()->with('failed', 'Wystąpił błąd podczas usuwania dostawcy');
        }
        return redirect()->back()->with('success', 'Dostawca został usunięty');
    }
}
