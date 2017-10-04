<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfNotAdmin
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
        if(!$request->user()->hasRole('admin'))
        {
            if($request->ajax()) {
                return response('Unauthorized', 401);
            }
            return redirect('/');

        }

        return $next($request);
    }
}
