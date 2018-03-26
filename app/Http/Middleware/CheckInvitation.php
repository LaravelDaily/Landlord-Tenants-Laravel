<?php

namespace App\Http\Middleware;

use Closure;

class CheckInvitation
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
        if (auth()->user()->invitation_token) {
            return redirect()->route('auth.change_password');
        }
        return $next($request);
    }
}
