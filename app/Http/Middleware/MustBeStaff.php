<?php

namespace App\Http\Middleware;

use Closure;

class MustBeStaff
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
        // dd(auth()->user());
        if (auth()->check() && auth()->user()->userprofile->usergroup_id == 2)
        {
            return $next($request);
        }

        
        elseif (auth()->check() && auth()->user()->userprofile->usergroup_id == 1)
        {
            return redirect('admin/dashboard');
        }


        return redirect('/');
    }
}
