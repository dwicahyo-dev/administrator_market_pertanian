<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CheckForAdmin
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
        $userRole = Auth::user()->userRoles()->first();

        if (empty($userRole)) {
            abort(403);
        }

        if ((!Auth::guest()) && ($userRole->id == 2)) {
            $remember = Auth::user()->remember_token;
            $password = Auth::user()->password;

            if (($remember == NULL) || (Hash::check('password', $password))) {
                return redirect()->route('password.request');
            }
            
            return $next($request);
        }
        
        return $next($request);

    }
}
