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



    public function search(Request $request)
    {
        $output = '';
        if($request->ajax())
        {
            $query = $request->get('query');
            if($query != '')
                $suppliers = suppliers::where('name', 'like', '%'.$query.'%')->orWhere('email', 'like', '%'.$query.'%')->orWhere('phone', 'like', '%'.$query.'%')->orderBy('name')->get();
            
            if($suppliers->count() > 0)
            {
                foreach($suppliers as $key => $supplier)
                {
                    $output .= '
                        <tr>
                            <td class="align-middle">'.($key+1).'</td>
                            <td class="align-middle">'.$supplier->name.'</td>
                            <td class="align-middle">'.$supplier->email.'</td>
                            <td class="align-middle">'.$supplier->phone.'</td>
                            <td class="align-middle"><a href="'.route('edit_supplier',['id' => $supplier->id]).'"><svg class="bi bi-pencil" width="1.5rem" height="1.5rem" viewBox="0 0 16 16" fill="#2842AB" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M11.293 1.293a1 1 0 011.414 0l2 2a1 1 0 010 1.414l-9 9a1 1 0 01-.39.242l-3 1a1 1 0 01-1.266-1.265l1-3a1 1 0 01.242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z" clip-rule="evenodd"/><path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 00.5.5H4v.5a.5.5 0 00.5.5H5v.5a.5.5 0 00.5.5H6v-1.5a.5.5 0 00-.5-.5H5v-.5a.5.5 0 00-.5-.5H3z" clip-rule="evenodd"/></svg></a></td>
                            <td class="align-middle"><button class="btn" data-target="#delete" data-toggle="modal" value="'.$supplier->id.'" onclick="modal_delete(this.value)"><svg class="bi bi-trash" width="1.5rem" height="1.5rem" viewBox="0 0 16 16" fill="red" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 5.5A.5.5 0 016 6v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm2.5 0a.5.5 0 01.5.5v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm3 .5a.5.5 0 00-1 0v6a.5.5 0 001 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 01-1 1H13v9a2 2 0 01-2 2H5a2 2 0 01-2-2V4h-.5a1 1 0 01-1-1V2a1 1 0 011-1H6a1 1 0 011-1h2a1 1 0 011 1h3.5a1 1 0 011 1v1zM4.118 4L4 4.059V13a1 1 0 001 1h6a1 1 0 001-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" clip-rule="evenodd"/></svg></button></td>
                        </tr>
                    ';
                }
            }
            else
            {
                $output = '
                    <tr>
                        <td></td>
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


    public function add_supplier(Request $request)
    {
        $supplier = [
            'name' => $request->nazwa,
            'email' => $request->email,
            'phone' => $request->telefon
        ];

        if(suppliers::whereName($request->nazwa)->first())
            return redirect(route('suppliers'))->with('failed', 'dostawca '.$request->nazwa.' juz istnieje');
        try
        {
            suppliers::create($supplier);
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect(route('suppliers'))->with('failed', 'Wystapił błąd podczas dodawania dostawcy');
        }
        return redirect(route('suppliers'))->with('success', 'Dodano nowego dostawcę');
        
    }


    public function edit($id)
    {
        $supplier = suppliers::findOrFail($id);
        return view('suppliers.edit_supplier')->with('supplier', $supplier);
    }


    public function edit_save(Request $request, $id)
    {
        try
        {
            $supplier = suppliers::findOrFail($id);
            $supplier->name = $request->nazwa;
            $supplier->email = $request->email;
            $supplier->phone = $request->telefon;
            $supplier->save();
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect()->back()->with('failed', 'Modyfikacja nie powiodła się');
        }
        return redirect(route('suppliers'))->with('success', 'Zmodyfikowano dostawcę');
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
