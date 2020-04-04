<?php

namespace App\Http\Middleware;

use Closure;

class CheckPasswordChange
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
        $request->validate([
            'stare_haslo' => 'required|string',
            'nowe_haslo' => 'required|string|min:8',
            'potw_nowe_haslo' => 'required|string|min:8|same:nowe_haslo'
        ]);
        return $next($request);
    }
}
