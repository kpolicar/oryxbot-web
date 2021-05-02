<?php

namespace App\Http\Middleware;

use App\Rules\Captcha as CaptchaRule;
use Closure;
use Illuminate\Http\Request;

class Captcha
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
        if (config('app.env') == 'production') {
            $request->validate([
                'g-recaptcha-response' => new CaptchaRule($request->ip())
            ]);
        }
        return $next($request);
    }
}
