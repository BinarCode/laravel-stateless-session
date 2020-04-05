<?php

namespace Binarcode\LaravelStatelessSession\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Session\TokenMismatchException;

class VerifyHeaderCsrfToken extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     *
     * @throws \Illuminate\Session\TokenMismatchException
     */
    public function handle($request, Closure $next)
    {
        if (
            $this->isReading($request) ||
            $this->runningUnitTests() ||
            $this->inExceptArray($request) ||
            $this->tokensMatch($request)
        ) {
            return tap($next($request), function ($response) use ($request) {
                $this->addHeaderToResponse($request, $response);
            });
        }

        throw new TokenMismatchException('CSRF token mismatch.');
    }


    /**
     * Add the CSRF token to the response headers.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function addHeaderToResponse($request, $response)
    {
        $config = config('session');

        $response->headers->set('XSRF-TOKEN', $request->session()->token());
        $response->headers->set('XSRF-TOKEN-EXPIRES', $this->availableAt(60 * $config['lifetime']));

        return $response;
    }

}
