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


    public function search(Request $request)
    {
        $output = '';
        if($request->ajax())
        {
            $query = $request->get('query');

            $products = products::where('name', 'like', '%'.$query.'%')->orderBy('name')->get();
            $suppliers_search = suppliers::where('name', 'like', '%'.$query.'%')->orWhere('email', 'like', '%'.$query.'%')->orderBy('name')->get();

            if($products->count() > 0 || $suppliers_search->count() > 0)
            {
                $suppliers = suppliers::all();
                $products_used = array();
                $j = 0;
                for($i=0; $i < $products->count(); $i++) 
                    foreach($suppliers as $supplier)
                        if($supplier->id == $products[$i]['supplier_id'])
                        {
                            $products_used[$j]['id'] = $products[$i]['id'];
                            $products_used[$j]['name'] = $products[$i]['name'];
                            $products_used[$j]['supplier'] = $supplier->name;
                            $j++;
                        }

                $x = $products->count();
                foreach($suppliers_search as $supp)
                {
                    $products_supp = products::whereSupplier_id($supp->id)->orderBy('name')->get();
                    foreach($products_supp as $row)
                    {
                        if(!in_array($row->id, $products_used))
                        {
                            $products_used[$x]['id'] = $row->id;
                            $products_used[$x]['name'] = $row->name;
                            $products_used[$x]['supplier'] = $supp->name;
                            $x++;
                        }
                    }
                }

                for($i=0; $i < count($products_used); $i++)
                {
                    $output .= '
                        <tr>
                            <td class="align-middle">'.($i+1).'</td>
                            <td class="align-middle">'.$products_used[$i]['name'].'</td>
                            <td class="align-middle">'.$products_used[$i]['supplier'].'</td>
                            <td class="align-middle"><a href="'.route('edit_product',['id' => $products_used[$i]['id']]).'"><svg class="bi bi-pencil" width="1.5rem" height="1.5rem" viewBox="0 0 16 16" fill="#2842AB" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M11.293 1.293a1 1 0 011.414 0l2 2a1 1 0 010 1.414l-9 9a1 1 0 01-.39.242l-3 1a1 1 0 01-1.266-1.265l1-3a1 1 0 01.242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z" clip-rule="evenodd"/><path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 00.5.5H4v.5a.5.5 0 00.5.5H5v.5a.5.5 0 00.5.5H6v-1.5a.5.5 0 00-.5-.5H5v-.5a.5.5 0 00-.5-.5H3z" clip-rule="evenodd"/></svg></a></td>
                            <td class="align-middle"><button class="btn" data-target="#delete" data-toggle="modal" value="'.$products_used[$i]['id'].'" onclick="modal_delete(this.value)"><svg class="bi bi-trash" width="1.5rem" height="1.5rem" viewBox="0 0 16 16" fill="red" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 5.5A.5.5 0 016 6v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm2.5 0a.5.5 0 01.5.5v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm3 .5a.5.5 0 00-1 0v6a.5.5 0 001 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 01-1 1H13v9a2 2 0 01-2 2H5a2 2 0 01-2-2V4h-.5a1 1 0 01-1-1V2a1 1 0 011-1H6a1 1 0 011-1h2a1 1 0 011 1h3.5a1 1 0 011 1v1zM4.118 4L4 4.059V13a1 1 0 001 1h6a1 1 0 001-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" clip-rule="evenodd"/></svg></button></td>
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
