<?php namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Contracts\Routing\Middleware;

class UserPasswordStatus implements Middleware
{

    public function handle($request, Closure $next)
    {
        if(Auth::user()->status == 2)
        {
          return redirect('auth/change_password');
        }

        return $next($request);
    }


}
