<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Auth;

use App\Mail\EmployeeRegister;
use App\Mail\NewEmployee;

use App\User;
use App\usersTokens;
use App\scheduler;
use App\vacations;

class EmployeeController extends Controller
{
    // user
    public function user()
    {
        return view('employees.user');
    }

    // all - admin
    public function all()
    {
        $users = User::paginate(15);
        return view('employees.admin')->withUsers($users);
    }

    // new - store
    public function new_store(Request $request)
    {
        try
        {
            $pass = Str::random(15);

            $vacation_active = false;
            if($request->vacation_active == 'on')
                $vacation_active = true;

            $active = false;
            if($request->active == 'on')
                $active = true;
            
    
            $user = new User;
            $user->name = $request->nazwa;
            $user->email = $request->email;
            $user->password = Hash::make($pass);
            $user->vacation_active = $vacation_active;
            $user->base_sallary = $request->base_sallary;
            $user->extended_sallary = $request->extended_sallary;
            $user->active = $active;
            $user->save();

            // $token = Str::random(60);
            // $token_hash = hash('sha512', $token);

            // $usersToken = new usersTokens;
            // $usersToken->email = $request->email;
            // $usersToken->token = $token_hash;
            // $usersToken->expired_at = Carbon::now()->addDays(1);
            // $usersToken->save();
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');
        }catch(\Exception $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');
        }

        // try
        // {
        //     // wysyłanie maila
        //     Mail::to(Auth::user()->email)->send(new NewEmployee($user->name, $pass));
        // }catch(\Exception $ex){
        //     return redirect()->back()->withFailed('Wystąpił błąd');
        // }

        // try
        // {
        //     // wysyłanie maila
        //     Mail::to($request->email)->send(new EmployeeRegister($user->id, $token_hash));
        // }catch(\Exception $ex){
        //     return redirect()->back()->withFailed('Wystąpił błąd');
        // }
        
        return redirect()->back()->withSuccess('Dodano użytkownika');
    }


    // edit
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('employees.edit')->withUser($user);
    }

    // edit - store
    public function edit_store(Request $request, $id)
    {
        try
        {
            $vacation_active = false;
            if($request->vacation_active == 'on')
                $vacation_active = true;

            $active = false;
            if($request->active == 'on')
                $active = true;

            $user = User::findOrFail($id);
            $user->name = $request->nazwa;
            $user->email = $request->email;
            $user->vacation_active = $vacation_active;
            $user->active = $active;
            $user->vacation_active = $vacation_active;
            $user->base_sallary = $request->base_sallary;
            $user->extended_sallary = $request->extended_sallary;
            $user->save();
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');
        }
        return redirect()->back()->withSuccess('Edytowano użytkownika');
    }

    // delete
    public function delete(Request $request)
    {
        try
        {
            scheduler::where('user_id', $request->id)->delete();
            vacations::where('user_id', $request->id)->delete();
            User::findOrFail($request->id)->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');
        }
        return redirect()->back()->withSuccess('Usunięto użytkownika');
    }

    // search
    public function search(Request $request)
    {
        $output = '';
        if($request->ajax())
        {
            $query = $request->get('query');

            $users = User::where('name', 'like', '%'.$query.'%')
                            ->orWhere('email', 'like', '%'.$query.'%')
                            ->get();

            if($users->count() > 0)
            {
                foreach($users as $key => $user)
                {
                    $output .= '
                        <tr>
                            <td class="align-middle">'.($key+1).'</td>
                            <td class="align-middle">'.$user->name.'</td>
                            <td class="align-middle">'.$user->email.'</td>
                            <td class="align-middle"><a href="'.route('edit_employee',['id' => $user->id]).'"><svg class="bi bi-pencil" width="1.5rem" height="1.5rem" viewBox="0 0 16 16" fill="#2842AB" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M11.293 1.293a1 1 0 011.414 0l2 2a1 1 0 010 1.414l-9 9a1 1 0 01-.39.242l-3 1a1 1 0 01-1.266-1.265l1-3a1 1 0 01.242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z" clip-rule="evenodd"/><path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 00.5.5H4v.5a.5.5 0 00.5.5H5v.5a.5.5 0 00.5.5H6v-1.5a.5.5 0 00-.5-.5H5v-.5a.5.5 0 00-.5-.5H3z" clip-rule="evenodd"/></svg></a></td>
                            <td class="align-middle"><button class="btn" data-target="#delete" data-toggle="modal" value="'.$user->id.'" onclick="modal_delete(this.value)"><svg class="bi bi-trash" width="1.5rem" height="1.5rem" viewBox="0 0 16 16" fill="red" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 5.5A.5.5 0 016 6v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm2.5 0a.5.5 0 01.5.5v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm3 .5a.5.5 0 00-1 0v6a.5.5 0 001 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 01-1 1H13v9a2 2 0 01-2 2H5a2 2 0 01-2-2V4h-.5a1 1 0 01-1-1V2a1 1 0 011-1H6a1 1 0 011-1h2a1 1 0 011 1h3.5a1 1 0 011 1v1zM4.118 4L4 4.059V13a1 1 0 001 1h6a1 1 0 001-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" clip-rule="evenodd"/></svg></button></td>
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


    // resend activation email
    // public function resend($id)
    // {
    //     try
    //     {
    //         $user = User::findOrFail($id);
    //         $userToken = usersTokens::whereEmail($user->email)->OrderBy('expired_at', 'desc')->first();

    //         if(Carbon::now()->lte($userToken->expired_at))
    //             return redirect()->back()->withFailed('Link aktywacyjny tego użytkownika jest jeszcze aktywny');
    //         else
    //         {
    //             $token_hash = hash('sha512', Str::random(60));
    //             $usersToken = new usersTokens;
    //             $usersToken->email = $user->email;
    //             $usersToken->token = $token_hash;
    //             $usersToken->expired_at = Carbon::now()->addDays(1);
    //             $usersToken->save();
    //         }
    //     }catch(\Illuminate\Database\QueryException $ex){
    //         return redirect()->back()->withFailed('Wystąpił błąd');
    //     }catch(\Exception $ex){
    //         return redirect()->back()->withFailed('Wystąpił błąd');
    //     }

    //     try
    //     {
    //         //wysyłanie maila
    //         Mail::to($request->email)->send(new EmployeeRegister($user->id, $token_hash));
    //     }catch(\Exception $ex){
    //         return redirect()->back()->withFailed('Wystąpił błąd');
    //     }
    //     return redirect()->back()->withSuccess('Email z linkiem aktywacyjnym został wysłany!');
    // }
}
