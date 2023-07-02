<?php

namespace Iamolayemi\Paystack\Endpoints;

class DedicatedAccount extends Endpoint
{
    protected const ENDPOINT = '/dedicated_account';

    /**
     * Create a Dedicated NUBAN and assign to a customer.
     *
     * @link https://paystack.com/docs/api/#dedicated-nuban-create
     */
    public function create(array $payload): self
    {
        $this->post($this->url(self::ENDPOINT), $payload);

        return $this;
    }

    /**
     * List dedicated accounts available on your integration.
     *
     * @link
     */
    public function list(array $query = []): self
    {
        $this->get($this->url(self::ENDPOINT), $query);

        return $this;
    }

    /**
     * Get details of a dedicated account on your integration.
     *
     * @link https://paystack.com/docs/api/#dedicated-nuban-fetch
     */
    public function fetch(string $account_id): self
    {
        $this->get($this->url(self::ENDPOINT).'/'.$account_id);

        return $this;
    }

    /**
     * Get details of a dedicated account on your integration.
     *
     * @link https://paystack.com/docs/api/#dedicated-nuban-deactivate
     */
    public function deactivate(string $account_id): self
    {
        $this->delete($this->url(self::ENDPOINT).'/'.$account_id);

        return $this;
    }

    /**
     * Split a dedicated account transaction with one or more accounts.
     *
     * @link https://paystack.com/docs/api/#dedicated-nuban-add-split
     */
    public function addSplit(array $payload): self
    {
        $this->post($this->url(self::ENDPOINT).'/split', $payload);

        return $this;
    }

    /**
     * Remove split payment for a dedicated account.
     *
     * @link https://paystack.com/docs/api/#dedicated-nuban-remove-split
     */
    public function removeSplit(array $payload): self
    {
        $this->delete($this->url(self::ENDPOINT).'/split', $payload);

        return $this;
    }

    /**
     * Get available bank providers for Dedicated NUBAN.
     *
     * @link https://paystack.com/docs/api/#dedicated-nuban-providers
     */
    public function providers(): self
    {
        $this->get($this->url(self::ENDPOINT).'/available_providers');

        return $this;
    }
}
