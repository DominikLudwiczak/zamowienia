<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class CheckActive
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
        if(Gate::allows('active'))
        {
            return $next($request);
        }
        else if(Auth::check())
        {
            Auth::logout();
            return redirect( route('login') )->with('failed', 'Twoje konto jest nieaktywne');
        }
        else
        {
            return redirect( route('login') );
        }
    }
}
