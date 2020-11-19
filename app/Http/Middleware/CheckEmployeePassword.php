<?php

namespace App\Http\Middleware;

use Closure;

use App\User;
use Auth;

class CheckEmployeePassword
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
        $usr = User::findOrFail(Auth::id());
        if($usr->pass_changed == null)
            return redirect()->route('password.change');
        return $next($request);
    }
}
