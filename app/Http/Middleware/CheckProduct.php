<?php

namespace App\Http\Middleware;

use Closure;

class CheckProduct
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
            'dostawca' => 'required|integer',
            'nazwa' => 'required|max:255'
        ], 
        [
            'integer' => 'Pole :attribute jest wymagane'
        ]);
        return $next($request);
    }
}
