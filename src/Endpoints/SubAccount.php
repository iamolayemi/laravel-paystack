<?php

namespace Iamolayemi\Paystack\Endpoints;

class SubAccount extends Endpoint
{
    protected const ENDPOINT = '/subaccount';

    /**
     * Create a subaccount on your integration.
     *
     * @link https://paystack.com/docs/api/#subaccount-create
     */
    public function create(array $payload): self
    {
        $this->post($this->url(self::ENDPOINT), $payload);

        return $this;
    }

    /**
     * List subaccounts available on your integration.
     *
     * @link https://paystack.com/docs/api/#subaccount-list
     */
    public function list(array $query = []): self
    {
        $this->get($this->url(self::ENDPOINT), $query);

        return $this;
    }

    /**
     * Get details of a subaccount on your integration.
     *
     * @link https://paystack.com/docs/api/#subaccount-fetch
     */
    public function fetch(string $subaccount_id): self
    {
        $this->get($this->url(self::ENDPOINT).'/'.$subaccount_id);

        return $this;
    }

    /**
     * Update a subaccount details on your integration.
     *
     * @link https://paystack.com/docs/api/#subaccount-update
     */
    public function update(string $subaccount_id, array $payload = []): self
    {
        $this->put($this->url(self::ENDPOINT).'/'.$subaccount_id, $payload);

        return $this;
    }
}
