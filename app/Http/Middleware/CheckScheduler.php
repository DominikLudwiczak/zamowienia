<?php

namespace App\Http\Middleware;

use Closure;

class CheckScheduler
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
            'date' => 'required|date|after:today',
            'start' => 'required|date_format:H:i|before:end',
            'end' => 'required|date_format:H:i|after:start',
            'user' => 'required|gt:0'
        ], 
        [
            'gt' => 'Pole :attribute jest wymagane'
        ],
        [
            'date' => 'data',
            'start' => 'początek',
            'end' => 'koniec',
            'user' => 'użytkownik'
        ]);
        return $next($request);
    }
}
