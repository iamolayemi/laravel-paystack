# Quickstart tutorial

This tutorial focuses on getting you started with this package quickly. We recommend following this tutorial just to get things working so that you can play with the package.

Make sure you've already installed this package in your project. You can check out our [Installation Guide](/installation) on how to install laravel paystack on your project.

In this tutorial, we will be implementing a simple payment gateway using this package.

## Setup Routes

Let's get started by setting up all the necessary route endpoints.

```php
// The route that the button calls to initialize payment
Route::post('/paystack/initialize', [PaymentController::class, 'initialize'])
    ->name('pay');

// The callback url after a payment
Route::get('/paystack/callback', [PaymentController::class, 'callback'])
    ->name('callback');
```

## Setup Views

In this section, Let's set up our views to collect payment information.

```html
<h3>Make Payment: N1500.00</h3>

<form method="POST" action="{{ route('pay') }}">
    @csrf

    <input name="name" placeholder="Name" />
    <input name="email" type="email" placeholder="Your Email"/>
    <input type="hidden" name="amount" value="150000"/>

    <input type="submit" value="Buy"/>
</form>
```

## Setup Controller

Now, we will need to create a controller to handle your application requests. We can create the file
app/Controllers/PaymentController.php like this:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Iamolayemi\Paystack\Facades\Paystack;

class PaymentController extends Controller
{
    /**
     * Initialize a new paystack payment
     *
     * @return void
     */
    public function initialize()
    {
        // Generate a unique payment reference
        $reference = Paystack::generateReference();

        // prepare payment details from form request
        $paymentDetails = [
            'email' => request('email'),
            'amount' => request('amount'),
            'reference' => $reference,
            'callback_url' =>  route('callback')
        ];

        // initialize new payment and get the response from the api call.
        $response = Paystack::transaction()
            ->initialize($paymentDetails)->response();

        if (!$response['status']) {
            // notify that something went wrong
        }

        // redirect to authorization url
        return redirect($response['data']['authorization_url']);
    }


    public function callback()
    {
        // get reference  from request
        $reference = request('reference') ?? request('trxref');

        // verify payment details
        $payment = Paystack::transaction()->verify($reference)->response('data');

        // check payment status
        if ($payment['status'] == 'success') {
            // payment is successful
            // code your business logic here
        } else {
            // payment is not successful
        }
    }
}
```
