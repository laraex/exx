<?php

namespace App\Http\Middleware;

use Closure;

class MustBeAdmin
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
        //dd('admin');
         // dd(auth()->user()->userprofile->usergroup_id);
        if (auth()->check() && auth()->user()->userprofile->usergroup_id == 1)
        {
            return $next($request);
        }

        if (auth()->check() && auth()->user()->userprofile->usergroup_id == 3)
        {
            return redirect('/home');
        }

        return redirect('/');
    }
}
