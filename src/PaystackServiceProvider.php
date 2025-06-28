<?php

namespace Iamolayemi\Paystack;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class PaystackServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        if (
            $this->app->runningInConsole()
        ) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('paystack.php'),
            ], 'config');
        }

        // Register custom validation rule for Laravel 10+
        Validator::extend('required_string', function ($attribute, $value, $parameters, $validator) {
            return is_string($value) && ! empty(trim($value));
        }, 'The :attribute must be a non-empty string.');
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'paystack');

        // Register the main class to use with the facade
        $this->app->bind('paystack', function () {
            // Validate required credentials
            $config = config('paystack');

            if (empty($config['secret_key'])) {
                throw new \InvalidArgumentException('Paystack secret key is required. Please set PAYSTACK_SECRET_KEY in your .env file.');
            }

            return new Paystack($config['secret_key']);
        });
    }
}
