<?php

namespace Iamolayemi\Paystack\Endpoints;

class Settlement extends Endpoint
{
    protected const ENDPOINT = '/settlement';

    /**
     * List settlements made to your settlement accounts.
     *
     * @param  array<string, mixed>  $query
     *
     * @link https://paystack.com/docs/api/#settlement-list
     */
    public function list(array $query = []): self
    {
        $this->get($this->url(self::ENDPOINT), $query);

        return $this;
    }

    /**
     * Get details of a settlement on your integration.
     *
     * @param  array<string, mixed>  $query
     *
     * @link https://paystack.com/docs/api/#settlement-fetch
     */
    public function fetch(string $settlement_id, array $query = []): self
    {
        $this->get($this->url(self::ENDPOINT).'/'.$settlement_id, $query);

        return $this;
    }
}
