<?php

namespace Iamolayemi\Paystack\Exceptions;

use Exception;

class PaystackConnectionException extends PaystackException
{
    public function __construct(string $message = 'Connection could not be established.', int $code = 0, ?Exception $previous = null, array $context = [])
    {
        parent::__construct($message, $code, $previous, $context);
    }
}
