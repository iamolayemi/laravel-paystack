<?php

namespace Iamolayemi\Paystack\Endpoints;

class Customer extends Endpoint
{
    protected const ENDPOINT = '/customer';

    /**
     * Create a customer on your integration.
     *
     * @link https://paystack.com/docs/api/#customer-create
     */
    public function create(array $payload): self
    {
        $this->post($this->url(self::ENDPOINT), $payload);

        return $this;
    }

    /**
     * List customers available on your integration.
     *
     * @link https://paystack.com/docs/api/#customer-list
     */
    public function list(array $query = []): self
    {
        $this->get($this->url(self::ENDPOINT), $query);

        return $this;
    }

    /**
     * Get details of a customer on your integration.
     *
     * @link https://paystack.com/docs/api/#customer-fetch
     */
    public function fetch(string $customer_email): self
    {
        $this->get($this->url(self::ENDPOINT).'/'.$customer_email);

        return $this;
    }

    /**
     * Update a customer's details on your integration.
     *
     * @link https://paystack.com/docs/api/#customer-update
     */
    public function update(string $customer_code, array $payload = []): self
    {
        $this->put($this->url(self::ENDPOINT).'/'.$customer_code, $payload);

        return $this;
    }

    /**
     * Validate a customer's identity.
     *
     * @link https://paystack.com/docs/api/#customer-validate
     */
    public function validate(string $customer_code, array $payload = []): self
    {
        $this->post($this->url(self::ENDPOINT).'/'.$customer_code.'/identification', $payload);

        return $this;
    }

    /**
     * Whitelist or blacklist a customer on your integration.
     *
     * @link https://paystack.com/docs/api/#customer-whitelist-blacklist
     */
    public function whitelist(array $payload): self
    {
        $this->post($this->url(self::ENDPOINT).'/set_risk_action', $payload);

        return $this;
    }

    /**
     * Deactivate an authorization when the card needs to be forgotten.
     *
     * @link https://paystack.com/docs/api/#customer-deactivate-authorization
     */
    public function deactivateAuthorization(array $payload): self
    {
        $this->post($this->url(self::ENDPOINT).'/deactivate_authorization', $payload);

        return $this;
    }
}
