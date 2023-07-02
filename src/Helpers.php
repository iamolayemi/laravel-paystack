<?php

if (! function_exists('paystack')) {
    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    function paystack()
    {
        return app()->make('paystack');
    }
}
