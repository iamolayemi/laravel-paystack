# Introduction

This package provides an expressive and convenient way to interact with the Paystack API within your Laravel Application. It provides a simple, fluent interface to work with.

Here are some quick code examples:

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
