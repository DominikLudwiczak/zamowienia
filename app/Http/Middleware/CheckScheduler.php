<?php

namespace App\Http\Middleware;

use Closure;

use App\User;
use App\scheduler;
use App\vacations;

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
            'date' => 'required|date',
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

        if($request->check === "true")
        {
            $schedulers = scheduler::where('date', $request->date)->where('end', '>', $request->start)->where('start', '<', $request->end)->where('id', '!=', $request->schedulerid)->get();
            $vacations = vacations::where('end', '>=', $request->date)->where('start', '<=', $request->date)->where('user_id', '=', $request->user)->where('confirmed', '>=', 0)->count();

            $check = false;
            if($schedulers->where('user_id', '=', $request->user)->count() > 0)
                $check = 'double_user';
            elseif($vacations > 0)
                $check = 'vacation';
            elseif($schedulers->where('shop_id', '=', $request->id)->count() > 0)
                $check = 'double_other_user';

            if($check != false)
                return redirect()->back()->withInput()->withDouble($check);
        }

        return $next($request);
    }
}
