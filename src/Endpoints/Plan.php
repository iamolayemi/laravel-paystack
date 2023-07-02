<?php

namespace Iamolayemi\Paystack\Endpoints;

class Plan extends Endpoint
{
    protected const ENDPOINT = '/plan';

    /**
     * Create a plan on your integration.
     *
     * @link https://paystack.com/docs/api/#plan-create
     */
    public function create(array $payload): self
    {
        $this->post($this->url(self::ENDPOINT), $payload);

        return $this;
    }

    /**
     * List plans available on your integration.
     *
     * @link https://paystack.com/docs/api/#plan-list
     */
    public function list(array $query = []): self
    {
        $this->get($this->url(self::ENDPOINT), $query);

        return $this;
    }

    /**
     * Get details of a plan on your integration.
     *
     * @link https://paystack.com/docs/api/#plan-fetch
     */
    public function fetch(string $plan_id): self
    {
        $this->get($this->url(self::ENDPOINT).'/'.$plan_id);

        return $this;
    }

    /**
     * Update a plan details on your integration.
     *
     * @link https://paystack.com/docs/api/#plan-update
     */
    public function update(string $plan_id, array $payload = []): self
    {
        $this->put($this->url(self::ENDPOINT).'/'.$plan_id, $payload);

        return $this;
    }
}
