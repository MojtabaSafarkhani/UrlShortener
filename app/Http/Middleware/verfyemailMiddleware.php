<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class verfyemailMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->email_verified_at == null) {
            return redirect(route('user.verifyemail'))->withErrors(['error'=>'you must verify your email !tanks :)']);
        }
        return $next($request);
    }
}
