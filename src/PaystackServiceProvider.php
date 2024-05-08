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
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('paystack.php'),
            ], 'config');
        }
        $this->validator();
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

            //validate required credentials
            $config = config('paystack');
            Validator::make($config, [
                'secret_key' => 'required|string',
            ])->validate();

            return new Paystack(config('paystack.secret_key'));
        });
    }


    private function validator()
    {
        Validator::macro('required_string', function ($attribute, $value, $arguments) {
            return is_string($value) && !empty($value);
        });
    }

}
