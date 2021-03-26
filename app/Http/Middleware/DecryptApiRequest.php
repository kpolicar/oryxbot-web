<?php

namespace App\Http\Middleware;

use App\Contracts\ApiEncrypter;
use Illuminate\Container\Container;
use PhpParser\JsonDecoder;
use Str;
use Crypt;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DecryptApiRequest
{
    private $crypt;

    public function __construct(Container $container)
    {
        $this->crypt = $container->get(ApiEncrypter::class);
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $decrypted = $this->crypt->decryptString($request->getContent());
        $message = json_decode($decrypted, true);

        $request->merge($message);
        return $next($request);
    }
}
