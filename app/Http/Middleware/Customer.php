<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;

class Customer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'ADMIN') {
                Auth::guard('web')->logout();

                $request->session()->invalidate();

                $request->session()->regenerateToken();
            }
        }        

        return $next($request);
    }
}
