<?php

namespace App\Http\Middleware;

use Closure;

use Auth;

class MonitorAdmin
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
        if(!Auth::check()) return abort(404);
        
        else if(auth()->user()->type <  1) return abort(404);

        return $next($request);
    }
}
