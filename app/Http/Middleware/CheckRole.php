<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if ($role == User::SUPPORTER_ROLE)
        {
            if ($request->user()->role == User::SUPPORTER_ROLE || $request->user()->role == User::ADMIN_ROLE)
            {
                return $next($request);
            }
        }

        if ($role == User::ADMIN_ROLE)
        {
            if ($request->user()->role == User::ADMIN_ROLE)
            {
                return $next($request);
            }
        }
        return abort(403, "Access denied");
    }
}
