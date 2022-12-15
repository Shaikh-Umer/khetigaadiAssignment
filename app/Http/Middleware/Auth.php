<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth as UserAuth;

class Auth
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

        if(!UserAuth::check()) {
            return redirect('/login');
        }
        return $next($request);
    }
}
