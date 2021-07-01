<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;

use App\User;
use Auth;

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
        if($request->type === 'set')
        {
            $request->validate([
                'nowe_haslo' => 'required|string|min:8',
                'potw_nowe_haslo' => 'required|string|same:nowe_haslo'
            ],[],
            [
                'nowe_haslo' => 'nowe hasło',
                'potw_nowe_haslo' => 'powtórz nowe hasło',
            ]);
        }
        else
        {
            $request->validate([
                'stare_haslo' => 'required|string',
                'nowe_haslo' => 'required|string|min:8|different:stare_haslo',
                'potw_nowe_haslo' => 'required|string|same:nowe_haslo'
            ],[],
            [
                'stare_haslo' => 'stare hasło',
                'nowe_haslo' => 'nowe hasło',
                'potw_nowe_haslo' => 'powtórz nowe hasło',
            ]);
        }
        return $next($request);
    }
}
