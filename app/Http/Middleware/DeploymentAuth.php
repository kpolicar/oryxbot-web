<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DeploymentAuth
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
        if ($request->hasHeader('authorization') === false) {
            abort(403);
        }

        $header = $request->getHeader('authorization');
        $jwt = \trim((string) \preg_replace('/^\s*Bearer\s/', '', $header[0]));

        if ($jwt !== config('services.github_actions.deployment_auth_key'))  {
            abort(403);
        }

        return $next($request);
    }
}
