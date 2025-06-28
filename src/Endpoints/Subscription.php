<?php

namespace Iamolayemi\Paystack\Endpoints;

class Subscription extends Endpoint
{
    protected const ENDPOINT = '/subscription';

    /**
     * Create a subscription on your integration.
     *
     * @link https://paystack.com/docs/api/#subscription-create
     */
    public function create(array $payload): self
    {
        $this->post($this->url(self::ENDPOINT), $payload);

        return $this;
    }

    /**
     * List subscriptions available on your integration.
     *
     * @link https://paystack.com/docs/api/#suzbscription-list
     */
    public function list(array $query = []): self
    {
        $this->get($this->url(self::ENDPOINT), $query);

        return $this;
    }

    /**
     * Get details of a subscription on your integration.
     *
     * @link https://paystack.com/docs/api/#subscription-fetch
     */
    public function fetch(string $subscription_id): self
    {
        $this->get($this->url(self::ENDPOINT).'/'.$subscription_id);

        return $this;
    }

    /**
     * Enable a subscription on your integration.
     *
     * @link https://paystack.com/docs/api/#subscription-enable
     */
    public function enable(array $payload): self
    {
        $this->post($this->url(self::ENDPOINT).'/enable', $payload);

        return $this;
    }

    /**
     * Disable a subscription on your integration.
     *
     * @link https://paystack.com/docs/api/#subscription-disable
     */
    public function disable(array $payload): self
    {
        $this->post($this->url(self::ENDPOINT).'/disable', $payload);

        return $this;
    }
}
