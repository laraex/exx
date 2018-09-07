<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\AuthenticationProcess;

class MustBeOTP
{
  
       use AuthenticationProcess;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      
        if (auth()->check() && auth()->user()->userprofile->usergroup_id == 1)
        {
            if($this->checkAuthentication())
            {
                return $next($request);
            }
            else
            {
                abort(403);
            }
        }

        if (auth()->check() && auth()->user()->userprofile->usergroup_id == 3)
        {
            return redirect('/home');
        }

        // if (auth()->check() && auth()->user()->userprofile->usergroup_id == USER_ROLE_ADMIN)
        // {
        //     return redirect(HOME_ADMIN);
        // }

        return redirect('/');       
    }
}
