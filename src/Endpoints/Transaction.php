<?php

namespace Iamolayemi\Paystack\Endpoints;

class Transaction extends Endpoint
{
    protected const ENDPOINT = '/transaction';

    /**
     * Initialize a transaction from your backend
     *
     * @param array $payload
     * @return Transaction
     * @link https://paystack.com/docs/api/#transaction-initialize
     */
    public function initialize(array $payload): self
    {
        $this->post($this->url(self::ENDPOINT) . '/initialize', $payload);
        return $this;
    }

    /**
     * Get the authorization url from the 'initialize' endpoint
     *
     * @return string
     */
    public function authorizationURL(): string
    {
        return $this->response->json('data.authorization_url');
    }

    /**
     * Confirm the status of a transaction.
     *
     * @param string $reference
     * @return Transaction
     * @link https://paystack.com/docs/api/#transaction-verify
     */
    public function verify(string $reference): self
    {
        $this->get($this->url(self::ENDPOINT) . '/verify/' . $reference);
        return $this;
    }

    /**
     * Get the status of a single transaction.
     *
     * @param string $reference
     * @return string
     */
    public function status(string $reference = ''): string
    {
        if (!empty($reference)) {
            return $this->verify($reference)->status();
        } else {
            return $this->response->json('data.status');
        }
    }

    /**
     * List transactions carried out on your integration.
     *
     * @param array $query
     * @return Transaction
     * @link https://paystack.com/docs/api/#transaction-list
     */
    public function list(array $query = []): self
    {
        $this->get($this->url(self::ENDPOINT), $query);
        return $this;
    }

    /**
     * Get details of a transaction carried out on your integration.
     *
     * @param int $transaction_id
     * @return Transaction
     * @link https://paystack.com/docs/api/#transaction-fetch
     */
    public function fetch(int $transaction_id): self
    {
        $this->get($this->url(self::ENDPOINT) . '/' . $transaction_id);
        return $this;
    }

    /**
     * Charge a customer user using his authorization code.
     *
     * @param array $payload
     * @return Transaction
     * @link https://paystack.com/docs/api/#transaction-charge-authorization
     */
    public function chargeAuthorization(array $payload): self
    {
        $this->post($this->url(self::ENDPOINT) . '/charge_authorization', $payload);
        return $this;
    }

    /**
     * Check if the authorization code is valid.
     *
     * @param array $payload
     * @return Transaction
     * @link https://paystack.com/docs/api/#transaction-check-authorization
     */
    public function checkAuthorization(array $payload): self
    {
        $this->post($this->url(self::ENDPOINT) . '/check_authorization', $payload);
        return $this;
    }

    /**
     * Fetch the timeline of a transaction
     *
     * @param string $reference
     * @return Transaction
     * @link https://paystack.com/docs/api/#transaction-view-timeline
     */
    public function timeline(string $reference): self
    {
        $this->get($this->url(self::ENDPOINT) . '/timeline/' . $reference);
        return $this;
    }

    /**
     * View the timeline of a transaction.
     *
     * @param array $query
     * @return Transaction
     * @link https://paystack.com/docs/api/#transaction-totals
     */
    public function totals(array $query = []): self
    {
        $this->get($this->url(self::ENDPOINT) . '/totals', $query);
        return $this;
    }

    /**
     * List transactions carried out on your integration.
     *
     * @param array $query
     * @return Transaction
     * @link https://paystack.com/docs/api/#transaction-export
     */
    public function export(array $query = []): self
    {
        $this->get($this->url(self::ENDPOINT) . '/export', $query);
        return $this;
    }

    /**
     * Receive part of a payment from a customer.
     *
     * @param array $payload
     * @return Transaction
     * @link https://paystack.com/docs/api/#transaction-export
     */
    public function partialDebit(array $payload): self
    {
        $this->post($this->url(self::ENDPOINT) . '/partial_debit', $payload);
        return $this;
    }
}
