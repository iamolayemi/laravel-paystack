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
     * @param \Illuminate\Foundation\Application $app
     * @return string[]
     */
    protected function getPackageProviders($app): array
    {
        return [
            PaystackServiceProvider::class,
        ];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return string[]
     */
    protected function getPackageAliases($app): array
    {
        return [
            'Paystack' => Paystack::class
        ];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    public function getEnvironmentSetUp($app): void
    {
        config()->set('paystack.secret_key', 'sk_test_**********');
    }
}
