<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
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
        if(Gate::allows('admin'))
        {
            return $next($request);
        }
        else if(Auth::check())
        {
            Auth::logout();
            return redirect( route('login') )->with('failed', 'Musisz być zalogowany jako administrator!');
        }
        else
        {
            return redirect( route('login') );
        }
    }
}
