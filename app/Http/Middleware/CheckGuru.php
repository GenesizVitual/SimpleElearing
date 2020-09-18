<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class CheckGuru
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
        if(empty(Session::get('id_guru'))){
            return redirect('/');
        }

        return $next($request);
    }
}
