<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use App\User;
use App\usersTokens;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    // change password
    public function change(Request $request)
    {
        $userData = $request->only('stare_haslo', 'nowe_haslo', 'potw_nowe_haslo');

        $credentials = ['email' => Auth::user()->email, 'password' => $userData['stare_haslo']];

        if(Auth::attempt($credentials))
        {
            try
            {
                User::whereEmail(Auth::user()->email)->update(['password' => Hash::make($userData['nowe_haslo']), 'pass_changed' => date("Y-m-d H:i:s")]);
                Auth::logoutOtherDevices($userData['nowe_haslo']);
                Auth::logout();
                return redirect(route('login'))->with('success', 'Zmiana hasła powiodła się!');
            }catch(\Illuminate\Database\QueryException $ex){
                return redirect()->back()->with('failed', 'Zmiana hasła nie powiodła się!');
            }catch(\Exception $ex){
                return redirect()->back()->with('failed', 'Zmiana hasła nie powiodła się!');
            }
        }
        return redirect()->back()->with('failed', 'Zmiana hasła nie powiodła się!');
    }
}
