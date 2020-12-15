<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\User;
use App\usersTokens;

use App\Mail\EmployeeVerified;



class VerificationController extends Controller
{
    public function verification($id, $token)
    {
        $check = true;
        try
        {
            $user = User::findOrFail($id);
            if($user->email_verified_at == null)
            {
                $userToken = usersTokens::whereEmail($user->email)->OrderBy('expired_at', 'desc')->first();
    
                if($userToken->token === $token && Carbon::now()->lte($userToken->expired_at))
                {
                    $user->email_verified_at = date("Y-m-d H:i:s");
                    $user->save();
    
                    $token = hash('sha512', Str::random(60));
                    $userToken->token = $token;
                    $userToken->expired_at = Carbon::now()->addDays(1);
                    $userToken->save();
    
                    //wysyłanie maila
                    Mail::to($user->email)->send(new EmployeeVerified($user->id, $token));
                }
                else
                    $check = false;
            }
        }catch(\Illuminate\Database\QueryException $ex){
            $check = false;
        }catch(\Exception $ex){
            $check = false;
        }
    
        if($check == true)
            return redirect(route('set_password', ['id' => $id, 'token' => $token]));
        
        if($check != true)
        {
            Auth::logout();
            return redirect(route('login'))->withFailed('wystapił błąd');
        }
    }


    public function setPassword($id, $token)
    {
        try
        {
            $user = User::findOrFail($id);
            if($user->pass_changed == null)
            {
                $userToken = usersTokens::whereEmail($user->email)->OrderBy('expired_at', 'desc')->first();
    
                if($userToken->token === $token && Carbon::now()->lte($userToken->expired_at))
                    return view('auth.passwords.set');
            }
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect(route('login'))->withFailed('Ustawienie hasła nie powiodło się!');
        }catch(\Exception $ex){
            return redirect(route('login'))->withFailed('Ustawienie hasła nie powiodło się!');        
        }
        return redirect(route('login'))->withFailed('Ustawienie hasła nie powiodło się!');
    }

    
    public function setPassword_store(Request $request, $id, $token)
    {
        try
        {
            $check = true;
            $user = User::findOrFail($id);
            if($user->pass_changed == null)
            {
                $userToken = usersTokens::whereEmail($user->email)->OrderBy('expired_at', 'desc')->first();
    
                if($userToken->token === $token && Carbon::now()->lte($userToken->expired_at))
                {
                    $user->password = Hash::make($request->nowe_haslo);
                    $user->pass_changed = date("Y-m-d H:i:s");
                    $user->save();
                    Auth::logout();
                }
                else
                    $check = false;
            }
            else
                $check = false;
        }catch(\Illuminate\Database\QueryException $ex){
            $check = false;
        }catch(\Exception $ex){
            $check = false;
        }

        if($check == true)
            return redirect(route('login'))->withSuccess('Ustawienie hasła powiodło się!');
        else
            return redirect(route('login'))->withFailed('Ustawienie hasła nie powiodło się!');
    }
}
