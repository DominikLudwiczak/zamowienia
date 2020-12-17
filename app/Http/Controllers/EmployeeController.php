<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Mail\EmployeeRegister;
// use Illuminate\Support\Facades\Password;

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
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');
        }catch(\Exception $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');
        }

        try
        {
            //wysyłanie maila
            Mail::to($request->email)->send(new EmployeeRegister($user->id, $token_hash));
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
            $active = false;
            if($request->active == 'on')
                $active = true;

            $user = User::findOrFail($id);
            $user->name = $request->nazwa;
            $user->email = $request->email;
            $user->active = $active;
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

    }


    // resend activation email
    public function resend($id)
    {
        try
        {
            $user = User::findOrFail($id);
            $userToken = usersTokens::whereEmail($user->email)->OrderBy('expired_at', 'desc')->first();

            if(Carbon::now()->lte($userToken->expired_at))
                return redirect()->back()->withFailed('Link aktywacyjny tego użytkownika jest jeszcze aktywny');
            else
            {
                $token_hash = hash('sha512', Str::random(60));
                $usersToken = new usersTokens;
                $usersToken->email = $user->email;
                $usersToken->token = $token_hash;
                $usersToken->expired_at = Carbon::now()->addDays(1);
                $usersToken->save();
            }
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');
        }catch(\Exception $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');
        }

        try
        {
            //wysyłanie maila
            Mail::to($request->email)->send(new EmployeeRegister($user->id, $token_hash));
        }catch(\Exception $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');
        }
        return redirect()->back()->withSuccess('Email z linkiem aktywacyjnym został wysłany!');
    }
}
