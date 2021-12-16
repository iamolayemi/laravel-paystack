<?php

namespace Iamolayemi\Paystack\Facades;

use Illuminate\Support\Facades\Facade;


class Paystack extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'paystack';
    }
}
