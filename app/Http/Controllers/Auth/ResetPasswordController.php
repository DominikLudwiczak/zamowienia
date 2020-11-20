<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
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

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    // set password
    public function set($id, $token)
    {
        try
        {
            $user = User::findOrFail($id);
            $userToken = usersTokens::whereEmail($user->email)->OrderBy('expired_at', 'desc')->first();

            if($userToken->token === $token && Carbon::now()->lte($userToken->expired_at))
                return view('auth.passwords.set');
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect(route('login'))->withFailed('Ustawienie hasła nie powiodła się!');
        }catch(\Exception $ex){
            return redirect(route('login'))->withFailed('Ustawienie hasła nie powiodła się!');
        }
        return redirect(route('login'))->withFailed('Ustawienie hasła nie powiodła się!');
    }


    // set password_store
    public function set_store(Request $request, $id, $token)
    {
        try
        {
            $user = User::findOrFail($id);
            $userToken = usersTokens::whereEmail($user->email)->OrderBy('expired_at', 'desc')->first();

            if($userToken->token === $token && Carbon::now()->lte($userToken->expired_at))
            {
                $user->password = Hash::make($request->nowe_haslo);
                $user->save();
                Auth::logout();
            }
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect(route('login'))->withFailed('Ustawienie hasła nie powiodła się!');
        }catch(\Exception $ex){
            return redirect(route('login'))->withFailed('Ustawienie hasła nie powiodła się!');
        }
        return redirect(route('login'))->withSuccess('Ustawienie hasła powiodła się!');
    }

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
