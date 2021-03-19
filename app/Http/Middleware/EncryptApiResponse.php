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

class EncryptApiResponse
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
        $response = $next($request);

        if ($response instanceof JsonResponse) {
            $data = json_encode($response->getData());
            $encrypted = $this->crypt->encryptString($data);

            $response = new Response($encrypted,
                $response->status(),
                $response->headers->all());
            $response->header('Content-Type', 'text/plain');
            $response->prepare($request);

        } else if ($response instanceof Response) {
            $message = $response->content();
            $encrypted = $this->crypt->encryptString($message);
            $response->setContent($encrypted);
            $response->header('Content-Type', 'text/plain');
        }

        return $response;
    }
}
