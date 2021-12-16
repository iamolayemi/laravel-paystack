<?php

namespace Iamolayemi\Paystack\Endpoints;

class Refund extends Endpoint
{

    protected const ENDPOINT = '/refund';

    /**
     * Initiate a refund on your integration.
     *
     * @param array $payload
     * @return Refund
     * @link https://paystack.com/docs/api/#refund-create
     */
    public function create(array $payload): self
    {
        $this->post($this->url(self::ENDPOINT), $payload);
        return $this;
    }

    /**
     * List refunds available on your integration.
     *
     * @param array $query
     * @return Refund
     * @link https://paystack.com/docs/api/#refund-list
     */
    public function list(array $query = []): self
    {
        $this->get($this->url(self::ENDPOINT), $query);
        return $this;
    }

    /**
     * Get details of a refund on your integration.
     *
     * @param string $reference
     * @return Refund
     * @link https://paystack.com/docs/api/#refund-fetch
     */
    public function fetch(string $reference): self
    {
        $this->get($this->url(self::ENDPOINT) . '/' . $reference);
        return $this;
    }
}
