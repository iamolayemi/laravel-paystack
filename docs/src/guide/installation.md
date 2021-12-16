# Installation
Laravel paystack can be installed via Composer:

> **Requires [PHP 7.4+](https://php.net/releases/) and [Laravel 8.0+](https://laravel.com/docs/8.x)**


```bash
composer require iamolayemi/laravel-paystack
```

## Configuration
You may publish the package configuration file by running the command

```bash
php artisan vendor:publish --provider="Iamolayemi\Paystack\PaystackServiceProvider"
```

A configuration file named **`paystack.php`** will be placed in **`app/config`** folder

## Environment Settings

Open your .env file and add your public key, secret key, callback url and webhook:

```dotenv
PAYSTACK_PUBLIC_KEY=pk_xxxxxxxxxxxxx
PAYSTACK_SECRET_KEY=sk_xxxxxxxxxxxxx
```

Congratulations :tada::tada::tada: , you are ready to start developing your application with this package.

