<?php

namespace Iamolayemi\Paystack\Tests;

use Iamolayemi\Paystack\Facades\Paystack;
use Iamolayemi\Paystack\PaystackServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @param  \Illuminate\Foundation\Application  $app
     * @return string[]
     */
    protected function getPackageProviders($app): array
    {
        return [
            PaystackServiceProvider::class,
        ];
    }

    /**
     * @param  \Illuminate\Foundation\Application  $app
     * @return array<string, class-string<\Illuminate\Support\Facades\Facade>>
     */
    protected function getPackageAliases($app): array
    {
        return [
            'Paystack' => Paystack::class,
        ];
    }
}
