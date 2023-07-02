<?php

namespace Iamolayemi\Paystack\Facades;

use Illuminate\Support\Facades\Facade;


class Paystack extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @see \Iamolayemi\Paystack\Paystack
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return \Iamolayemi\Paystack\Paystack::class;
    }
}
