<?php

namespace Iamolayemi\Paystack\Endpoints;

class Invoice extends Endpoint
{
    protected const ENDPOINT = '/paymentrequest';

    /**
     * Create an invoice on your integration.
     *
     * @link https://paystack.com/docs/api/#invoice-create
     */
    public function create(array $payload): self
    {
        $this->post($this->url(self::ENDPOINT), $payload);

        return $this;
    }

    /**
     * List the invoice available on your integration.
     *
     * @link https://paystack.com/docs/api/#invoice-list
     */
    public function list(array $query = []): self
    {
        $this->get($this->url(self::ENDPOINT), $query);

        return $this;
    }

    /**
     * Get details of an invoice on your integration.
     *
     * @link https://paystack.com/docs/api/#invoice-fetch
     */
    public function fetch(string $invoice_id): self
    {
        $this->get($this->url(self::ENDPOINT).'/'.$invoice_id);

        return $this;
    }

    /**
     * Verify details of an invoice on your integration.
     *
     * @link https://paystack.com/docs/api/#invoice-verify
     */
    public function verify(string $invoice_code): self
    {
        $this->get($this->url(self::ENDPOINT).'/verify/'.$invoice_code);

        return $this;
    }

    /**
     * Send notification of an invoice to your customers.
     *
     * @link https://paystack.com/docs/api/#invoice-send-notification
     */
    public function notify(string $invoice_code): self
    {
        $this->post($this->url(self::ENDPOINT).'/notify/'.$invoice_code);

        return $this;
    }

    /**
     * Get invoice metrics for dashboard.
     *
     * @link https://paystack.com/docs/api/#invoice-total
     */
    public function totals(): self
    {
        $this->post($this->url(self::ENDPOINT).'/totals');

        return $this;
    }

    /**
     * Finalize a draft invoice.
     *
     * @link https://paystack.com/docs/api/#invoice-finalize
     */
    public function finalize(string $invoice_code): self
    {
        $this->post($this->url(self::ENDPOINT).'/finalize/'.$invoice_code);

        return $this;
    }

    /**
     * Update an invoice details on your integration.
     *
     * @link https://paystack.com/docs/api/#invoice-update
     */
    public function update(string $invoice_id, array $payload = []): self
    {
        $this->put($this->url(self::ENDPOINT).'/'.$invoice_id, $payload);

        return $this;
    }

    /**
     * Update an invoice details on your integration.
     *
     * @link https://paystack.com/docs/api/#invoice-archive
     */
    public function archive(string $invoice_code): self
    {
        $this->post($this->url(self::ENDPOINT).'/archive/'.$invoice_code);

        return $this;
    }
}
