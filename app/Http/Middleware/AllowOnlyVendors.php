<?php

namespace App\Http\Middleware;

use App\Enums\UserTypes;
use App\Vendor;
use Closure;
use Illuminate\Auth\Access\HandlesAuthorization;

class AllowOnlyVendors
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
        if (! $request->user() instanceof Vendor) {
            $this->deny();
        }

        return $next($request);
    }
}
