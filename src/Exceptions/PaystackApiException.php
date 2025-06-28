<?php

namespace Iamolayemi\Paystack\Exceptions;

use Exception;

/**
 * Exception thrown when Paystack API returns an error response.
 */
class PaystackApiException extends PaystackException
{
    protected ?string $endpoint = null;

    /** @var array<string, mixed>|null */
    protected ?array $response = null;

    /**
     * @param  array<string, mixed>|null  $response
     */
    public function __construct(
        string $message = '',
        int $code = 0,
        ?string $endpoint = null,
        ?array $response = null,
        ?Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->endpoint = $endpoint;
        $this->response = $response;
    }

    public function getEndpoint(): ?string
    {
        return $this->endpoint;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getResponse(): ?array
    {
        return $this->response;
    }

    /**
     * @param  array<string, mixed>  $response
     */
    public static function fromResponse(array $response, string $endpoint): self
    {
        $message = $response['message'] ?? 'Unknown API error';
        $code = $response['status'] ?? 0;

        return new self($message, $code, $endpoint, $response);
    }
}
