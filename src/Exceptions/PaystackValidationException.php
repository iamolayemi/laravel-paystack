<?php

namespace Iamolayemi\Paystack\Exceptions;

use Exception;

class PaystackValidationException extends PaystackException
{
    protected array $errors = [];

    public function __construct(string $message = 'Validation failed.', int $code = 0, ?Exception $previous = null, array $context = [], array $errors = [])
    {
        parent::__construct($message, $code, $previous, $context);
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setErrors(array $errors): self
    {
        $this->errors = $errors;

        return $this;
    }
}
