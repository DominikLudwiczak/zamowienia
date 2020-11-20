<?php

namespace App\Http\Middleware;

use Closure;

use App\User;
use Auth;

class CheckVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = User::findOrFail(Auth::id());
        if($user->email_verified_at == null)
        {
            Auth::logout();
            return redirect(route('login'))->withFailed('Potwierdź swój adres email');
        }
        return $next($request);
    }
}
