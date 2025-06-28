<?php

if (! function_exists('paystack')) {
    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    function paystack(): \Iamolayemi\Paystack\Paystack
    {
        return app()->make('paystack');
    }
}
