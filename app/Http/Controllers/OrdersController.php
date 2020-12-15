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
use App\Mail\Order;
use Session;
use Auth;
use hash;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('CheckActive');
        $this->middleware('CheckAdmin');
    }


    public function orders()
    {
        $orders = orders::join('users', 'users.id', '=', 'orders.user_id')
                        ->select('orders.*', 'users.name as user')
                        ->OrderBy('orders.created_at', 'desc')
                        ->paginate(15);
        return view('orders.orders')->with('orders', $orders);
    }



    public function search(Request $request)
    {
        $output = '';
        if($request->ajax())
        {
            $query = $request->get('query');

            $orders = orders::join('users', 'users.id', '=', 'orders.user_id')
                            ->join('suppliers', 'suppliers.name', '=', 'orders.supplier')
                            ->select('orders.*', 'users.name as user')
                            ->where('orders.supplier', 'like', '%'.$query.'%')
                            ->orWhere('orders.order_id', 'like', '%'.$query.'%')
                            ->orWhere('users.name', 'like', '%'.$query.'%')
                            ->orWhere('suppliers.email', 'like', '%'.$query.'%')
                            ->orWhere('suppliers.phone', 'like', '%'.$query.'%')
                            ->orderBy('orders.created_at', 'desc')
                            ->get();
            if($orders->count() > 0)
            {
                foreach($orders as $key => $order)
                {
                    $output .= '
                        <tr class="table-row" data-href="'.route('order_details',['order_id' => $order->order_id]).'">
                            <td class="align-middle">'.($key+1).'</td>
                            <td class="align-middle">'.$order->supplier.'</td>
                            <td class="align-middle">'.$order->user.'</td>
                            <td class="align-middle">'.Carbon::parse($order->created_at)->diffForHumans().'</td>
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
                $products = orderDetails::where([['order_id', '=', $var],['name', 'like', '%'.$query.'%']])->orWhere('ammount', 'like', '%'.$query.'%')->orderBy('name')->get();

            if($products->count() > 0)
            {
                foreach($products as $key => $product)
                {
                    $output .= '
                        <tr>
                            <td class="align-middle">'.($key+1).'</td>
                            <td class="align-middle">'.$product->name.'</td>';
                            if($type == 'new_order')
                            {
                                $ammount = "";
                                if(session("order"))
                                    for($i=0; $i < count(session("order")); $i++)
                                        if(session("order")[$i]["name"] == $product->name)
                                            $ammount = session("order")[$i]["ammount"];
                                $output .= '<td><div class="col-sm-12 col-md-4 mx-auto"><input type="number" name="product_'.$product->id.'" oninput="set_ammount('.$product->id.')" value="'.$ammount.'"class="form-control"/></div></td>';
                            }
                            else
                                $output .= '<td class="align-middle">'.$product->ammount.'</td>';
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
        $order = orders::whereOrder_id($order_id)->first();
        $order_details = orderDetails::whereOrder_id($order_id)->get();
        return view('orders.details')->with('products', $order_details)->with('order', $order);
    }


    public function new_order($supplier_name = null)
    {
        $suppliers = suppliers::all();
        $supplier = suppliers::whereName($supplier_name)->first();
        if(!$supplier_name || !$supplier)
            return view('orders.new_order')->with('suppliers', $suppliers);
        else if($supplier)
        {
            if(session('supplier') != $supplier)
            {
                Session::forget('order');
                session(['supplier' => $supplier]);
            }
            $products = products::whereSupplier_id($supplier->id)->get();
            return view('orders.new_order')->with('suppliers', $suppliers)->with('products', $products);
        }
        return redirect(route('orders'))->with('failed', 'Wystąpił nieoczekiwany błąd');
    }


    public function setAmmount(Request $request)
    {
        if($request->ajax())
        {
            $product = products::findOrFail($request->get('id'))->name;
            $ammount = $request->get('ammount');
            $order = array();

            if(!session('order'))
                $i = 0;
            else
            {
                $i = count(session('order'));
                $order = session('order');
            }

            $check = false;
            for($i=0; $i < count($order); $i++)
                if($order[$i]['name'] == $product)
                {
                    if($ammount == 0)
                    {
                        unset($order[$i]);
                        $order = array_values($order);
                    }
                    else if($ammount == '' || $ammount > 0)
                    {
                        $order[$i]['name'] = $product;
                        $order[$i]['ammount'] = $ammount;
                    }
                    $check = true;
                    break;
                }
            if($check == false && ($ammount == '' || $ammount > 0))
            {
                $order[$i]['name'] = $product;
                $order[$i]['ammount'] = $ammount;
            }
            session(['order' => $order]);
        }
    }


    public function confirm(Request $request)
    {
        $products = products::whereSupplier_id(session('supplier')->id)->get()->toarray();
        if(count($products) == 0)
            return redirect()->back()->with('failed', 'Brak towarów dla tego dostawcy');
        if(!session('order'))
            return redirect()->back()->with('failed', 'Wybierz towary, które chcesz zamówić');
        return view('orders.confirm');
    }


    public function confirm_search(Request $request)
    {
        $output = '';
        if($request->ajax())
        {
            $query = $request->get('query');
            if($query == '')
            {
                for($i=0; $i < count(session('order')); $i++)
                {
                    $output .= '<tr>
                        <th scope="row">'.($i+1).'</th>
                        <td>'.session('order')[$i]['name'].'</td>
                        <td>'.session('order')[$i]['ammount'].'</td>
                    </tr>';
                }
            }
            else
            {
                $order = session('order');
                $check = false;
                for($i=0; $i < count($order); $i++)
                    if(strpos($order[$i]['name'], $query) !== false || strpos($order[$i]['ammount'], $query) !== false)
                    {
                        $output .= '<tr>
                                        <td class="align-middle">'.($i+1).'</td>
                                        <td class="align-middle">'.$order[$i]['name'].'</td>
                                        <td class="align-middle">'.$order[$i]['ammount'].'</td>
                                    </tr>';
                        $check = true;
                    }
                if($check == false)
                {
                    $output .= '<tr>
                                    <td></td>
                                    <td class="align-middle">Nie znaleziono</td>
                                    <td></td>
                                </tr>';
                }
            }
        }
        $data = array('table_data' => $output);
        echo json_encode($data);
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
        try
        {
            $order_id = $this->order_id_generate();

            $order = new orders;
            $order->order_id = $order_id;
            $order->supplier = session('supplier')->name;
            $order->user_id = Auth::id();
            $order->msg = $request->msg;
            $order->save();

            for($i=0; $i < count(session('order')); $i++)
            {
                $order_details = [
                    'order_id' => $order_id,
                    'name' => session('order')[$i]['name'],
                    'ammount' => session('order')[$i]['ammount']
                ];
                orderDetails::create($order_details);
            }
            //wysyłanie maila
            Mail::to(session('supplier')->email)->send(new Order($order));
            Session::forget(['order', 'supplier']);
            
            return redirect(route('dashboard'))->with('success', 'Zamówienie zostało wysłane');
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect(route('new_order', ['supplier_name' => session('supplier')->name]))->with('failed', 'Nie udało się wysłać zamówienia, spróbuj ponownie później');
        }catch(Exception $ex){
            return redirect(route('new_order', ['supplier_name' => session('supplier')->name]))->with('failed', ' udało się wysłać zamówienia, spróbuj ponownie później');
        }
    }
}