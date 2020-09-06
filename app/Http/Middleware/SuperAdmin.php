<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class SuperAdmin
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
        else if($request->ajax() && auth()->user()->type <  3 )
        {
            return response()->json(['failed'=>__('all.not_authorized')]);
        }
        else if(auth()->user()->type <  3) return abort(404);
        
        return $next($request);
    }
}
