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

class OrdersController extends Controller
{
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
                    $orders[$i]['supplier_id'] = $supplier->name;
            foreach($users as $user)
                if($orders[$i]['user_id'] == $user->id)
                    $orders[$i]['user_id'] = $user->name;
            $orders[$i]['created_at'] = Carbon::parse($orders[$i]['created_at'])->diffForHumans();
        }
        return view('orders.orders')->with('orders', $orders);
    }


    public function new_order_suppliers()
    {
        if(session('supplier'))
        {
            $request = new Request;
            return $this->new_order_choosen($request);
        }
        $suppliers = suppliers::all();
        return view('orders.new_order')->with('suppliers', $suppliers);
    }

    public function new_order_choosen(Request $request)
    {
        if($request->supplier == '' && !session('supplier'))
            return redirect(route('new_order'))->with('failed', 'Wybierz dostawcę');
        else if($request->has('supplier'))
        {
            $supplier = $request->supplier;
            session(['supplier' => suppliers::findOrFail($supplier)]);
        }
        else if(session('supplier'))
            $supplier = session('supplier')->id;
        else
            return redirect(route('new_order'))->with('failed', 'Wystąpił nieoczekiwany błąd');
        $suppliers = suppliers::all();
        $products = products::whereSupplier_id($supplier)->get();
        return view('orders.new_order')->with('suppliers', $suppliers)->with('products', $products);
    }


    public function confirm(Request $request)
    {
        $products = products::whereSupplier_id(session('supplier')->id)->get()->toarray();
        $order = array();
        $j=0;
        if(count($products) == 0)
            return redirect(route('new_order'))->with('failed', 'Brak towarów dla tego dostawcy');
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
            return redirect(route('new_order'))->with('failed', 'Wybierz towary, które chcesz zamówić');
        session(['order' => $order]);
        return view('orders.confirm');
    }

    public function send(Request $request)
    {
        $data=[
            'msg' => $request->msg,
        ];
        session(['msg' => $request->msg]);
        try
        {
            zmienic maila na maila dostawcy
            Mail::send('emails.order', $data, function($message){
                $message->from(Auth::user()->email, 'PHU Marta')->to('ludek088@gmail.com')->Subject('Zamówienie '.date('d.m.Y'));
            });
            $order_id = rand(19982, 18927946);
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
            return redirect('dashboard')->with('succes', 'Zamówienie zostało wysłane');
        }catch(Exception $ex)
        {
            return redirect(route('new_order'))->with('failed', 'Nie udało się wysłać zamówienia, spróbuj ponownie później');
        }
    }
}