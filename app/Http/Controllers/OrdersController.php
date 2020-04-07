<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\products;
use App\orders;
use App\orderDetails;
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
        $orders_all = orders::OrderBy('created_at', 'desc')->paginate(15);
        $orders = array();
        $i = 0 ;
        foreach($orders_all as $order)
        {
            $orders[$i]['order_id'] = $order->order_id;
            $orders[$i]['supplier'] = $order->supplier;
            $orders[$i]['user'] = user::findOrFail($order->user_id)->name;
            $orders[$i]['created_at'] = Carbon::parse($order->created_at)->diffForHumans();
            $i++;
        }
        return view('orders.orders')->with('orders', $orders)->with('paginate', $orders_all);
    }



    public function search(Request $request)
    {
        $output = '';
        if($request->ajax())
        {
            $query = $request->get('query');

            $orders = orders::where('order_id', 'like', '%'.$query.'%')->orWhere('supplier', 'like', '%'.$query.'%')->orderBy('created_at')->get();
            $users_search = user::where('name', 'like', '%'.$query.'%')->orderBy('name')->get();

            if($orders->count() > 0 || $users_search->count() > 0)
            {
                $users = user::all();
                $orders_used = array();
                $j = 0;
                for($i=0; $i < $orders->count(); $i++) 
                    foreach($users as $user)
                        if($user->id == $orders[$i]['user_id'])
                        {
                            $orders_used[$j]['order_id'] = $orders[$i]['order_id'];
                            $orders_used[$j]['supplier'] = $orders[$i]['supplier'];
                            $orders_used[$j]['user'] = $user->name;
                            $orders_used[$j]['date'] = Carbon::parse($orders[$j]['created_at'])->diffForHumans();
                            $j++;
                        }

                $x = $orders->count();
                foreach($users_search as $usr)
                {
                    $orders_usr = orders::whereUser_id($usr->id)->orderBy('created_at')->get();
                    foreach($orders_usr as $row)
                    {
                        if(!in_array($row->order_id, $orders_used))
                        {
                            $orders_used[$x]['order_id'] = $row->order_id;
                            $orders_used[$x]['supplier'] = $row->supplier;
                            $orders_used[$x]['user'] = $usr->name;
                            $orders_used[$j]['date'] = Carbon::parse($row->created_at)->diffForHumans();
                            $x++;
                        }
                    }
                }

                for($i=0; $i < count($orders_used); $i++)
                {
                    $output .= '
                        <tr class="table-row" data-href="'.route('order_details',['order_id' => $orders_used[$i]['order_id']]).'">
                            <td class="align-middle">'.($i+1).'</td>
                            <td class="align-middle">'.$orders_used[$i]['supplier'].'</td>
                            <td class="align-middle">'.$orders_used[$i]['user'].'</td>
                            <td class="align-middle">'.$orders_used[$i]['date'].'</td>
                        </tr>
                    ';
                }
            }
            else
            {
                $output = '
                    <tr>
                        <td></td>
                        <td class="align-middle">Nie znaleziono</td>
                        <td></td>
                        <td></td>
                    </tr>
                ';
            }
            $data = array('table_data' => $output);
            echo json_encode($data);
        }
    }



    public function search_prod(Request $request)
    {
        $output = '';
        if($request->ajax())
        {
            $query = $request->get('query');
            $var = $request->get('var');
            $type = $request->get('type');

            if($type == 'new_order')
                $products = products::where([['supplier_id', '=', $var],['name', 'like', '%'.$query.'%']])->orderBy('name')->get();
            else
                $products = orderDetails::where([['order_id', '=', $order_id],['product', 'like', '%'.$query.'%']])->orWhere('ammount', 'like', '%'.$query.'%')->orderBy('product')->get();

            if($products->count() > 0)
            {
                foreach($products as $key => $product)
                {
                    $output .= '
                        <tr>
                            <td class="align-middle">'.($key+1).'</td>';
                            if($type == "new_order" || $type='confirm')
                            {
                                $output .= '<td class="align-middle">'.$product->name.'</td>';
                                if($type == 'new_order')
                                {
                                    if(session("order"))
                                    {
                                        $ammount = "";
                                        for($i=0; $i < count(session("order")); $i++)
                                            if(session("order")[$i]["name"] == $product->name)
                                                $ammount = session("order")[$i]["ammount"];
                                    }
                                    $output .= '<td><div class="col-sm-12 col-md-4 mx-auto"><input type="number" name="product_'.$product->id.'" value="'.$ammount.'"class="form-control"/></div></td>';
                                }    
                            }
                            
                            if($type == 'details' || $type='confirm')
                            {
                                if($type == 'details')
                                    $output .= '<td class="align-middle">'.$product->product.'</td>';
                                $output .= '<td class="align-middle">'.$product->ammount.'dd</td>';
                            }
                    $output .= '</tr>';
                }
            }
            else
            {
                $output = '
                    <tr>
                        <td></td>
                        <td class="align-middle">Nie znaleziono</td>
                        <td></td>
                    </tr>
                ';
            }
            $data = array('table_data' => $output);
            echo json_encode($data);
        }
    }


    public function order_details($order_id)
    {
        $supplier = orders::whereOrder_id($order_id)->first()->supplier;
        $order_details = orderDetails::whereOrder_id($order_id)->get();
        return view('orders.details')->with('products', $order_details)->with('supplier', $supplier)->with('order_id', $order_id);
    }


    public function new_order($supplier_name = null)
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
            return redirect()->back()->with('failed', 'Brak towarów dla tego dostawcy');
        for($i = $products[0]['id']; $i <= $products[count($products)-1]['id']; $i++)
        {
            if($request->has("product_".$i) && $request['product_'.$i] > 0)
            {
                $order[$j]['name'] = products::findOrFail($i)->name;
                $order[$j]['ammount'] = $request['product_'.$i];
                $j++;
            }
        }
        if(count($order) == 0)
            return redirect()->back()->with('failed', 'Wybierz towary, które chcesz zamówić');
        session(['order' => $order]);
        return view('orders.confirm');
    }

    private function order_id_generate()
    {
        do
        {
            if($last_id = orders::orderBy('id', 'desc')->first())
                $last_id = $last_id->id;
            else
                $last_id = 0;
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
                $message->from('phumarta.sklep@gmail.com', 'PHU Marta')->to(session('supplier')->email)->Subject('Zamówienie '.date('d.m.Y'));
            });
            $order_id = $this->order_id_generate();
            $order = [
                'order_id' => $order_id,
                'supplier' => session('supplier')->name,
                'user_id' => Auth::user()->id
            ];
            orders::create($order);
            for($i=0; $i < count(session('order')); $i++)
            {
                $order_details = [
                    'order_id' => $order_id,
                    'product' => session('order')[$i]['name'],
                    'ammount' => session('order')[$i]['ammount']
                ];
                orderDetails::create($order_details);
            }
            Session::forget(['order', 'supplier', 'msg']);
            return redirect(route('dashboard'))->with('success', 'Zamówienie zostało wysłane');
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect()->back()->with('failed', 'Nie udało się wysłać zamówienia, spróbuj ponownie później');
        }catch(Exception $ex){
            return redirect()->back()->with('failed', 'Nie udało się wysłać zamówienia, spróbuj ponownie później');
        }
    }
}