<?php

namespace App\Http\Middleware;

use Closure;

use App\User;

class CheckEmployeeEdit
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
            'nazwa' => 'required',
            'email' => 'required|email'
        ]);

        if(User::whereName($request->nazwa)->where('id', '!=', $request->route('id'))->count() > 0)
            return redirect()->back()->withInput()->withFailed('Ta nazwa użytkownika jest już zajeta');
        if(User::whereEmail($request->email)->where('id', '!=', $request->route('id'))->count() > 0)
            return redirect()->back()->withInput()->withFailed('Ten adres email jest już zajety');

        return $next($request);
    }
}
