<?php

namespace Iamolayemi\Paystack\Exceptions;

use Exception;

class PaystackApiException extends PaystackException
{
    protected ?string $apiCode = null;
    protected ?string $apiMessage = null;

    public function __construct(
        string $message = "API request failed.",
        int $code = 0,
        ?Exception $previous = null,
        array $context = [],
        ?string $apiCode = null,
        ?string $apiMessage = null
    ) {
        parent::__construct($message, $code, $previous, $context);
        $this->apiCode = $apiCode;
        $this->apiMessage = $apiMessage;
    }

    public function getApiCode(): ?string
    {
        return $this->apiCode;
    }

    public function getApiMessage(): ?string
    {
        return $this->apiMessage;
    }

    public static function fromApiResponse(array $response): self
    {
        $message = $response['message'] ?? 'API request failed';
        $apiCode = $response['data']['errors'][0]['code'] ?? null;
        $apiMessage = $response['data']['errors'][0]['message'] ?? null;

        return new self($message, 0, null, $response, $apiCode, $apiMessage);
    }
}
