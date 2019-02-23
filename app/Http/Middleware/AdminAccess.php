<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminAccess
{
	use HandlesAuthorization;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! $request->user()->is_admin) {
            $this->deny();
        }

        return $next($request);
    }
}