<?php

namespace App\Http\Middleware;

use Closure;

use App\User;
use App\scheduler;

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

        $schedulers = scheduler::where('date', $request->date)->where('end', '>', $request->start)->where('start', '<', $request->end)->where('id', '!=', $request->schedulerid)->get();
        
        $check = false;
        if($schedulers->where('user_id', '=', $request->user)->count() > 0)
            $check = 'double_user';
        elseif($schedulers->where('shop_id', '=', $request->id)->count() > 0)
            $check = 'double_other_user';

        if($check != false)
            return redirect()->back()->withInput()->withDouble($check);

        return $next($request);
    }
}
