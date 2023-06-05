#

[![Latest Version on Packagist](https://img.shields.io/packagist/v/iamolayemi/laravel-paystack.svg?style=flat-square)](https://packagist.org/packages/iamolayemi/laravel-paystack)
[![Total Downloads](https://img.shields.io/packagist/dt/iamolayemi/laravel-paystack.svg?style=flat-square)](https://packagist.org/packages/iamolayemi/laravel-paystack)
[![Build Status](https://img.shields.io/travis/iamolayemi/laravel-paystack.svg)](https://travis-ci.org/iamolayemi/laravel-paystack)
[![Quality Score](https://img.shields.io/scrutinizer/g/iamolayemi/laravel-paystack.svg?style=flat-square)](https://scrutinizer-ci.com/g/iamolayemi/laravel-paystack)
![GitHub Actions](https://github.com/iamolayemi/laravel-paystack/actions/workflows/main.yml/badge.svg)

This package provides an expressive and convenient way to interact with the Paystack API within your Laravel
Application.

## Installation

> **Requires [PHP 8.1+](https://php.net/releases/)**

You can install the package via composer:

```bash
composer require iamolayemi/laravel-paystack
```

## Usage

Open your .env file and add your public key, secret key, callback url and webhook:

```dotenv
PAYSTACK_PUBLIC_KEY=pk_xxxxxxxxxxxxx
PAYSTACK_SECRET_KEY=sk_xxxxxxxxxxxxx
```

This package provides some fluent interface to interact with the paystack api. To learn all about it, head over
to [the extensive documentation](https://laravel-paystack.netlify.app).

Here are some of the things you can do with this package.

```php
/**
 * Initialize a new payment, and return the response from the api call
 */
Paystack::transaction()->initialize($paymentData)->response();

/**
 * Using the helper function
 */
paystack()->transaction()->initialize($paymentData)->response();
```

You can also get a specific data from the api call by passing in the key of the data you want to return as an argument
in the response() method

```php
/**
 * Initialize a new payment, and return only the authorization url
 */
Paystack::transaction()->initialize($paymentData)->response('data.authorization_url');

/**
 * Using the helper function
 */
paystack()->transaction()->initialize($paymentData)->response('data.authorization_url');
```

Alternatively, this package also provide another fluent method that make it easy to fetch only the authorization url.

```php
/**
 * Initialize a new payment, and return the authorization url
 */
Paystack::transaction()->initialize($paymentData)->authorizationURL();

/**
 * Using the helper function
 */
paystack()->transaction()->initialize($paymentData)->authorizationURL();
```

## Documentation

You'll find the documentation on [https://laravel-paystack.netlify.app](https://laravel-paystack.netlify.app).

Find yourself stuck using the package? Found a bug? Do you have general questions or suggestions for improving the media
library? Feel free to [create an issue on GitHub](https://github.com/iamolayemi/laravel-paystack/issues), we'll try to
address it as soon as possible.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please
email [olatayo.olayemi.peter@gmail.com](mailto:olatayo.olayemi.peter@gmail.com]) instead of using the issue tracker.

## Credits

- [Olayemi Olatayo](https://github.com/iamolayemi)
- [All Contributors](../../contributors)

## Alternatives

- [unicodeveloper/laravel-paystack](https://github.com/unicodeveloper/laravel-paystack)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
