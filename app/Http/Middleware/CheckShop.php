<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Validator;
use Closure;

class CheckShop
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
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'city' => 'required',
            'street' => 'required',
            'number' => 'required',
            'postal' => 'required'
        ],[],
        [
            'name' => 'Nazwa',
            'city' => 'Miejscowość',
            'street' => 'Ulica',
            'number' => 'Numer',
            'postal' => 'Kod pocztowy'
        ]);

        if ($validation->fails())
            return redirect()->back()->withErrors($validation)->withInput();

        return $next($request);
    }
}
