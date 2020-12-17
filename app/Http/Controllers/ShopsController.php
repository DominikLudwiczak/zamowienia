<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\shops;

class ShopsController extends Controller
{
    // shops
    public function shops()
    {
        $shops = shops::paginate(15);
        return view('shops.shops')->withShops($shops);
    }

    // edit
    public function edit($id)
    {
        $shop = shops::findOrFail($id);
        return view('shops.edit_shop')->withShop($shop);
    }


    // edit_store
    public function edit_store(Request $request, $id)
    {
        try
        {
            $postal = explode('-', $request->postal);
            $shop = shops::findOrFail($id);
            $shop->name = $request->name;
            $shop->city = $request->city;
            $shop->street = $request->street;
            $shop->number = $request->number;
            $shop->postal = $postal[0].$postal[1];
            $shop->save();
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect()->back()->withFailed('Wystąpił błąd podczas aktualizacji danych sklepu');    
        }

        return redirect()->back()->withSuccess('Zaktualizowano dane sklepu');
    }


    // delete
    public function delete(Request $request)
    {
        try
        {
            // DODAĆ USUWANIE Z GRAFIKÓW!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            shops::findOrFail($request->id)->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect()->back()->withFailed('Wystąpił błąd podczas usuwania sklepu');
        }
        return redirect()->back()->withSuccess('Sklep został usunięty');
    }

    // add
    public function add_store(Request $request)
    {
        try
        {
            $postal = explode('-', $request->postal);
            $shop = new shops;
            $shop->name = $request->name;
            $shop->city = $request->city;
            $shop->street = $request->street;
            $shop->number = $request->number;
            $shop->postal = $postal[0].$postal[1];
            $shop->save();
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect()->back()->withFailed('Wystąpił błąd podczas aktualizacji dodawania sklepu');    
        }

        return redirect()->back()->withSuccess('Dodano nowy sklep');
    }


    // search
    public function search(Request $request)
    {
        $output = '';
        if($request->ajax())
        {
            $query = $request->get('query');

            $shops = shops::where('name', 'like', "%$query%")
                            ->orWhere('city', 'like', "%$query%")
                            ->orWhere('street', 'like', "%$query%")
                            ->orWhere('number', 'like', "%$query%")
                            ->orWhere('postal', 'like', "%$query%")
                            ->get();

            if($shops->count() > 0)
            {
                foreach($shops as $key => $shop)
                {
                    $output .= "
                        <tr class='table-row table-row__hover'>
                            <td class=align-middle>".($key+1)."</td>
                            <td class=align-middle>$shop->name</td>
                            <td class=align-middle><a href='".route('edit_shop',['id' => $shop->id])."'><svg class='bi bi-pencil' width='1.5rem' height='1.5rem' viewBox='0 0 16 16' fill='#2842AB' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M11.293 1.293a1 1 0 011.414 0l2 2a1 1 0 010 1.414l-9 9a1 1 0 01-.39.242l-3 1a1 1 0 01-1.266-1.265l1-3a1 1 0 01.242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z' clip-rule='evenodd'/><path fill-rule='evenodd' d='M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 00.5.5H4v.5a.5.5 0 00.5.5H5v.5a.5.5 0 00.5.5H6v-1.5a.5.5 0 00-.5-.5H5v-.5a.5.5 0 00-.5-.5H3z' clip-rule='evenodd'/></svg></a></td>
                            <td class=align-middle><button class='btn' data-target='#delete' data-toggle='modal' value='$shop->id' onclick='modal_delete(this.value)'><svg class='bi bi-trash' width='1.5rem' height='1.5rem' viewBox='0 0 16 16' fill='red' xmlns='http://www.w3.org/2000/svg'><path d='M5.5 5.5A.5.5 0 016 6v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm2.5 0a.5.5 0 01.5.5v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm3 .5a.5.5 0 00-1 0v6a.5.5 0 001 0V6z'/><path fill-rule='evenodd' d='M14.5 3a1 1 0 01-1 1H13v9a2 2 0 01-2 2H5a2 2 0 01-2-2V4h-.5a1 1 0 01-1-1V2a1 1 0 011-1H6a1 1 0 011-1h2a1 1 0 011 1h3.5a1 1 0 011 1v1zM4.118 4L4 4.059V13a1 1 0 001 1h6a1 1 0 001-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z' clip-rule='evenodd'/></svg></button></td>
                    </tr>";
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
                    </tr>
                ';
            }
            $data = array('table_data' => $output);
            echo json_encode($data);
        }
    }
}
