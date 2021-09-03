<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckGM
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

        if(auth()->user()->auth != 2) {
            return redirect('/')->withErrors(['잘못된 접근입니다.']);
        }

        return $next($request);


    }
}
