<?php

namespace Iamolayemi\Paystack\Exceptions;

use Exception;

/**
 * Exception thrown when input validation fails.
 */
class PaystackValidationException extends PaystackException
{
    /** @var array<string, string> */
    protected array $errors = [];

    /**
     * @param  array<string, string>  $errors
     */
    public function __construct(
        string $message = '',
        array $errors = [],
        int $code = 0,
        ?Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    /**
     * @return array<string, string>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function addError(string $field, string $message): self
    {
        $this->errors[$field] = $message;

        return $this;
    }

    public function hasErrors(): bool
    {
        return ! empty($this->errors);
    }
}
