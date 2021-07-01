<?php

namespace App\Http\Middleware;

use Closure;

class CheckHoliday
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
            'name' => 'required',
            'date' => 'required|date'
        ],[],[
            'name' => 'Nazwa święta',
            'date' => 'Data święta'
        ]);

        return $next($request);
    }
}
