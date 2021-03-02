<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HasNeverSubscribed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->subscriptions()->exists())
            abort(404);
        return $next($request);
    }
}
