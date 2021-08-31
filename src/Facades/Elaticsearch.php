<?php

namespace Haode\Elaticsearch\Facades;

use Illuminate\Support\Facades\Facade;

class Elaticsearch extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'elaticsearch';
    }
}
