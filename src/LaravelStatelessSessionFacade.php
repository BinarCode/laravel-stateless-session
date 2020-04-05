<?php

namespace Binarcode\LaravelStatelessSession;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Binarcode\LaravelStatelessSession\Skeleton\SkeletonClass
 */
class LaravelStatelessSessionFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-stateless-session';
    }
}
