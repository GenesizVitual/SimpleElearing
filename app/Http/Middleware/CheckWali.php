<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class CheckWali
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
        if(empty(Session::get('id_wali_murid'))){
            return redirect('/');
        }
        return $next($request);
    }
}
