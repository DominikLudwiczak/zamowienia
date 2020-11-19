<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\User;
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
        $pass = Str::random(10);

        $active = false;
        if($request->active == 'on')
            $active = true;

        $user = new User;
        $user->name = $request->nazwa;
        $user->email = $request->email;
        $user->password = Hash::make($pass);
        $user->active = $active;
        $user->save();

        return view('emails.employee')->withPass($pass)->withUrl(env('APP_URL').'/login');
        try
        {
            Mail::send('emails.employee', array(), function($message){
                $message->from('phumarta.sklep@gmail.com', 'PHU Marta')->to($request->email)->Subject('Nowy pracownik');
            });
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');
        }
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

    }
}
