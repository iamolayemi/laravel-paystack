<?php

namespace Iamolayemi\Paystack\Exceptions;

use Exception;

/**
 * Exception thrown when there's a connection issue with Paystack API.
 */
class PaystackConnectionException extends PaystackException
{
    protected ?string $url = null;

    public function __construct(string $message = '', int $code = 0, ?string $url = null, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->url = $url;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public static function connectionFailed(string $url, ?Exception $previous = null): self
    {
        return new self(
            'Failed to connect to Paystack API',
            0,
            $url,
            $previous
        );
    }
}
