<?php

namespace InfyOmLabs\LaravelEnvato;

use Illuminate\Support\Facades\Facade;

/**
 * @see \InfyOmLabs\LaravelEnvato\Skeleton\SkeletonClass
 */
class LaravelEnvatoFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-envato';
    }
}
