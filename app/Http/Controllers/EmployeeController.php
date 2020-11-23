<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Password;

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

            $token = Str::random(60);
            $token_hash = hash('sha512', $token);

            $usersToken = new usersTokens;
            $usersToken->email = $request->email;
            $usersToken->token = $token_hash;
            $usersToken->expired_at = Carbon::now()->addDays(1);
            $usersToken->save();

            $dane = array('url' => route('email_verify', ['id' => $user->id, 'token' => $token_hash]));
            Mail::send('emails.employee', $dane, function($message){
                $message->from('phumarta.sklep@gmail.com', 'PHU Marta')->to((string)$request->email)->Subject('Weryfikacja email');
            });

        }catch(\Illuminate\Database\QueryException $ex){            
            return redirect()->back()->withFailed('Wystąpił błąd');
        }catch(\Exception $ex){
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
