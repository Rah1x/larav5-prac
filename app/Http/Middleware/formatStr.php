<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use mainHelper;
use format_str;

class formatStr
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
        //$request->input() = format_str($request->input());
        //mainHelper::var_dumpx('x', $request->input());

        return $next($request);
    }
}
