<?php

namespace App\Http\Middleware;

use Closure;

class CheckDiableAcc
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
        //not needed I did it by validation in login (exits)
        if(auth()->check() && auth()->user()->disable_account == 1)
        {
            auth()->logout();
            return redirect()->route('login')->withMessage("your account disabled contact the adminstrator");
        }
        return $next($request);
    }
}
