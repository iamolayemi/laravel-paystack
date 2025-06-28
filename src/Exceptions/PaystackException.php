<?php

namespace Iamolayemi\Paystack\Exceptions;

use Exception;

/**
 * Base exception class for all Paystack-related exceptions.
 */
class PaystackException extends Exception
{
    /** @var array<string, mixed> */
    protected array $context = [];

    /**
     * @param  array<string, mixed>  $context
     */
    public function __construct(
        string $message = '',
        int $code = 0,
        ?Exception $previous = null,
        array $context = []
    ) {
        parent::__construct($message, $code, $previous);
        $this->context = $context;
    }

    /**
     * @return array<string, mixed>
     */
    public function getContext(): array
    {
        return $this->context;
    }

    /**
     * @param  array<string, mixed>  $context
     */
    public function setContext(array $context): self
    {
        $this->context = $context;

        return $this;
    }
}
