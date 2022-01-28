<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth as Auth;

class AccessAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        /**
         * Checking if the user is connected as an admin
         * 
         */
        if(Auth::check() && Auth::user()->hasAnyRole(['admin'])) {
            return $next($request);
        }

        return redirect('home');
    }
}
