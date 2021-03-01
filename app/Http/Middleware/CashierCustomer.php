<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CashierCustomer
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
        if (!$request->user()->hasStripeId()) {
            $request->user()->createAsStripeCustomer();
        }
        return $next($request);
    }
}
