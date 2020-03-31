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
}
