<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Closure;

class CheckVacation
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
            $validation = Validator::make($request->all(), [
                'user' => 'numeric'
            ],[],
            [
                'start' => 'Początek',
                'end' => 'Koniec',
                'user' => 'Użytkownik'
            ]);
        }
        else
        {
            $validation = Validator::make($request->all(), [
                'start' => 'required|date|before_or_equal:end|after:today',
                'end' => 'required|date|after_or_equal:start',
                'user' => 'numeric'
            ],
            [
                'before_or_equal' => 'Pole :attribute musi być datą nie późniejszą niż :date.',
                'after_or_equal' => 'Pole :attribute musi być datą nie wcześniejszą niż :date.',
                'afetr' => 'Pole :attribute musi być datą późniejszą niż dzisiaj.'
            ],
            [
                'start' => 'Początek',
                'end' => 'Koniec',
                'user' => 'Użytkownik'
            ]);
        }

        if ($validation->fails())
            return redirect()->back()->withErrors($validation)->withInput();

        return $next($request);
    }
}
