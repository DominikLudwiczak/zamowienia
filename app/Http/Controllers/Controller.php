<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\products;
use App\orders;
use App\suppliers;
use App\user;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function orders()
    {
        $orders = orders::all()->toArray();
        $suppliers = suppliers::all();
        $users = user::all();
        for($i=0; $i < count($orders); $i++)
        {
            foreach($suppliers as $supplier)
                if($orders[$i]['supplier_id'] == $supplier->id)
                    $orders[$i]['supplier_id'] = $supplier->nazwa;
            foreach($users as $user)
                if($orders[$i]['user_id'] == $user->id)
                    $orders[$i]['user_id'] = $user->name;
            $orders[$i]['created_at'] = Carbon::parse($orders[$i]['created_at'])->diffForHumans();
        }
        return view('orders')->with('orders', $orders);
    }

    public function suppliers()
    {
        $suppliers = suppliers::all();
        return view('suppliers')->with('suppliers', $suppliers);
    }

    public function products()
    {
        $products = products::all()->toArray();
        $suppliers = suppliers::all();
        for($i=0; $i < count($products); $i++)
            foreach($suppliers as $supplier)
                if($supplier->id == $products[$i]['supplier_id'])
                    $products[$i]['supplier_id'] = $supplier->nazwa;
        return view('products')->with('products', $products);
    }
}