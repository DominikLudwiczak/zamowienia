<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\products;
use App\orders;
use App\suppliers;
use App\user;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Session;
use Auth;
use hash;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function orders()
    {
        $orders_all = orders::select('order_id')->groupBy('order_id')->OrderBy('created_at', 'desc')->paginate(15);
        $suppliers = suppliers::all();
        $users = user::all();
        $orders = array();
        $i = 0 ;
        foreach($orders_all as $order)
        {
            $order_detail = orders::whereOrder_id($order->order_id)->first();
            $orders[$i]['order_id'] = $order->order_id;
            foreach($suppliers as $supplier)
                if($order_detail->supplier_id == $supplier->id)
                    $orders[$i]['supplier'] = $supplier->name;
            foreach($users as $user)
                if($order_detail->user_id == $user->id)
                    $orders[$i]['user'] = $user->name;
            $orders[$i]['created_at'] = Carbon::parse($order_detail->created_at)->diffForHumans();
            $i++;
        }
        return view('orders.orders')->with('orders', $orders)->with('paginate', $orders_all);
    }



    public function order_details($order_id)
    {
        $order = orders::whereOrder_id($order_id)->get();
        $supplier = suppliers::findOrFail($order[0]['supplier_id']);
        $products = products::whereSupplier_id($supplier->id)->get();
        $produkty = array();
        $i = 0;
        foreach($order as $row)
            foreach($products as $product)
                if($row->product_id == $product->id)
                {
                    $produkty[$i]['name'] = $product->name;
                    $produkty[$i]['ammount'] = $row->ammount;
                    $i++;
                }
        return view('orders.details')->with('products', $produkty)->with('supplier', $supplier->name)->with('order_id', $order_id);
    }


    public function new_order_suppliers($supplier_name = null)
    {
        $suppliers = suppliers::all();
        $supplier = suppliers::whereName($supplier_name)->first();
        if(!$supplier_name || !$supplier)
            return view('orders.new_order')->with('suppliers', $suppliers);
        else if($supplier)
        {
            session(['supplier' => $supplier]);
            $products = products::whereSupplier_id($supplier->id)->get();
            return view('orders.new_order')->with('suppliers', $suppliers)->with('products', $products);
        }
        return redirect(route('orders'))->with('failed', 'Wystąpił nieoczekiwany błąd');
    }


    public function confirm(Request $request)
    {
        $products = products::whereSupplier_id(session('supplier')->id)->get()->toarray();
        $order = array();
        $j=0;
        if(count($products) == 0)
            return redirect(route('new_order', ['supplier_name' => session('supplier')->name]))->with('failed', 'Brak towarów dla tego dostawcy');
        for($i = $products[0]['id']; $i <= $products[count($products)-1]['id']; $i++)
            if($request->has("product_".$i))
                if($request['product_'.$i] > 0)
                {
                    $order[$j]['id'] = $products[$j]['id'];
                    $order[$j]['name'] = $products[$j]['name'];
                    $order[$j]['ammount'] = $request['product_'.$i];
                    $j++;
                }
        if(count($order) == 0)
            return redirect(route('new_order', ['supplier_name' => session('supplier')->name]))->with('failed', 'Wybierz towary, które chcesz zamówić');
        session(['order' => $order]);
        return view('orders.confirm');
    }

    private function order_id_generate()
    {
        do
        {
            $last_id = orders::orderBy('id', 'desc')->first()->id;
            $order_id = '';
            if(strlen($last_id) < 10)
            {
                for($i=0; $i <= (10-strlen($last_id)); $i++)
                    if($i == 4)
                        $order_id = $order_id.$last_id;
                    else
                        $order_id = $order_id.mt_rand(0, 9);
            }
            else
            {
                $hashed = hash::make($last_id);
                $order_id = substr($hashed, 25, 35);
            }
            $check_order_id = orders::whereOrder_id($order_id)->first();
        } while($check_order_id);
        return $order_id;
    }
    

    public function send(Request $request)
    {
        session(['msg' => $request->msg]);
        try
        {
            $data=array();
            Mail::send('emails.order', $data, function($message){
                $message->from('restauracja.divaldo@gmail.com', 'PHU Marta')->to(session('supplier')->email)->Subject('Zamówienie '.date('d.m.Y'));
            });
            $order_id = $this->order_id_generate();
            for($i=0; $i < count(session('order')); $i++)
            {
                $zamowienie = [
                    'order_id' => $order_id,
                    'supplier_id' => session('supplier')->id,
                    'product_id' => session('order')[$i]['id'],
                    'ammount' => session('order')[$i]['ammount'],
                    'user_id' => Auth::user()->id,
                ];
                $save=orders::create($zamowienie);
            }
            Session::forget(['order', 'supplier', 'msg']);
            return redirect(route('dashboard'))->with('success', 'Zamówienie zostało wysłane');
        }catch(Exception $ex)
        {
            return redirect(route('new_order'))->with('failed', 'Nie udało się wysłać zamówienia, spróbuj ponownie później');
        }
    }
}