<?php

namespace Binarcode\LaravelStatelessSession;

use Illuminate\Session\SessionManager as LaravelSessionManager;
use Illuminate\Session\Store;

class SessionManager extends LaravelSessionManager
{
    /**
     * Build the session instance.
     *
     * @param  \SessionHandlerInterface  $handler
     * @return \Illuminate\Session\Store
     */
    protected function buildSession($handler)
    {
        return $this->app['config']['session.encrypt']
            ? $this->buildEncryptedSession($handler)
            : new Store($this->app['config']['stateless.header'], $handler);
    }

}
