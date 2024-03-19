<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;

class Admin
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
            if (Auth::user()->role == 'CUSTOMER') {
                Auth::guard('web')->logout();

                $request->session()->invalidate();

                $request->session()->regenerateToken();

                return redirect()->route('admin.login');
            }
            
            if ($request->routeIs('admin.login')) {
                return redirect()->route('admin');
            }
        } else {
            if ($request->routeIs('admin.login')) {
                return $next($request);
            }
            return redirect()->route('admin.login');
        }
        

        return $next($request);
    }
}
