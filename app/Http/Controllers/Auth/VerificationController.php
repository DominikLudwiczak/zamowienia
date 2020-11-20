<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\User;
use App\usersTokens;
use Auth;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    public function verification(Request $request, $id, $token)
    {
        $check = true;
        try
        {
            $user = User::findOrFail($id);
            $userToken = usersTokens::whereEmail($user->email)->OrderBy('expired_at', 'desc')->first();

            if($userToken->token === $token && Carbon::now()->lte($userToken->expired_at))
            {
                $user->email_verified_at = date("Y-m-d H:i:s");
                $user->save();

                $token = hash('sha512', Str::random(60));
                $userToken->token = $token;
                $userToken->expired_at = Carbon::now()->addDays(1);
                $userToken->save();
            }
            else
                $check = false;
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
}
