<?php

namespace App\Http\Middleware;

use Closure;

class CheckSupplier
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
            'nazwa' => 'required|max:255',
            'email' => 'required|email',
            'telefon' => 'required|max:11|min:9'
        ]);
        return $next($request);
    }
}
