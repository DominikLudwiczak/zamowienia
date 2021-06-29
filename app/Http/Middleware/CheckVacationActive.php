<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\User;

class CheckVacationActive
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
        try
        {
            $user = User::findOrFail(Auth::id());
            if($user->vacation_active != 1)
                return redirect()->back()->withFailed('Nie możesz teraz zapisać się na urlop');
        }catch(\Illuminate\Database\QueryException $ex){
            return redirect()->back()->withFailed('Wystąpił błąd');
        }

        return $next($request);
    }
}
