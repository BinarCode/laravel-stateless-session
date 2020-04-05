<?php

namespace Binarcode\LaravelStatelessSession\Http\Middleware;

use Closure;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Session\Store;
use Symfony\Component\HttpFoundation\Response;

class StatelessStartSession extends StartSession
{
    public function handle($request, Closure $next)
    {
        if ( ! $this->sessionConfigured()) {
            return $next($request);
        }

        $request->setLaravelSession(
            $session = $this->startSession($request)
        );

        $this->collectGarbage($session);

        $response = $next($request);

        $this->storeCurrentUrl($request, $session);

        $this->addHeaderToResponse($response, $session);

        $this->saveSession($request);

        return $response;
    }

    /**
     * Get the session implementation from the manager.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Session\Session
     */
    public function getSession(Request $request)
    {
        return tap($this->manager->driver(), function (Store $session) use ($request) {
            $session->setId($request->headers->get($session->getName()));
        });
    }

    /**
     * Add the session header to the application response.
     *
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @param \Illuminate\Contracts\Session\Session $session
     * @return void
     */
    protected function addHeaderToResponse(Response $response, Session $session)
    {
        if ($this->sessionIsPersistent($config = $this->manager->getSessionConfig())) {
            $response->headers->set($session->getName(), $session->getId(), true);
            $response->headers->set('Access-Control-Expose-Headers', [$session->getName(), 'XSRF-TOKEN'], true);
        }
    }
}
