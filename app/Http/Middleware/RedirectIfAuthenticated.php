<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect(Auth::guard($guard)->user()->homeUrl());
        }

        return $next($request);
    }

    public function an_authenticated_user_will_be_redirected_to_their_home_if_visits_login_page()
    {
        $user = $this->signIn();

        $this->get('/login')
            ->assertRedirect($user->homeUrl());
    }
}
