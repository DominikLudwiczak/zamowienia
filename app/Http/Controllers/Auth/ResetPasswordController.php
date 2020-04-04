<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\User;

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

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function change(Request $request)
    {
        $userData = $request->only('stare_haslo', 'nowe_haslo', 'potw_nowe_haslo');

        $credentials = ['email' => Auth::user()->email, 'password' => $userData['stare_haslo']];

        if(Auth::attempt($credentials))
        {
            try
            {
                User::whereEmail(Auth::user()->email)->update(['password' => Hash::make($userData['nowe_haslo']), 'remember_token' => null]);
                Auth::logoutOtherDevices($userData['nowe_haslo']);
                Auth::logout();
                return redirect( route('login') )->with('success', 'Zmiana hasła powiodła się!');
            }catch(\Illuminate\Database\QueryException $ex){
                return redirect( route('dashboard') )->with('failed', 'Zmiana hasła nie powiodła się!');
            }
        }
        return redirect( route('dashboard') )->with('failed', 'Zmiana hasła nie powiodła się!');
    }
}
