<?php

namespace Iamolayemi\Paystack\Endpoints;

class TransferRecipient extends Endpoint
{
    protected const ENDPOINT = '/transferrecipient';

    /**
     * Creates a new recipient. A duplicate account number will lead to the retrieval of the existing record.
     *
     * @param  array<string, mixed>  $payload
     *
     * @link https://paystack.com/docs/api/#transfer-recipient-create
     */
    public function create(array $payload): self
    {
        $this->post($this->url(self::ENDPOINT), $payload);

        return $this;
    }

    /**
     * Creates multiple transfer recipients in batches. A duplicate account number will lead to the retrieval of the existing record.
     *
     * @param  array<string, mixed>  $payload
     *
     * @link https://paystack.com/docs/api/#transfer-recipient-bulk
     */
    public function createBulk(array $payload): self
    {
        $this->post($this->url(self::ENDPOINT).'/bulk', $payload);

        return $this;
    }

    /**
     * List transfer recipients available on your integration.
     *
     * @param  array<string, mixed>  $query
     *
     * @link https://paystack.com/docs/api/#transfer-recipient-list
     */
    public function list(array $query = []): self
    {
        $this->get($this->url(self::ENDPOINT), $query);

        return $this;
    }

    /**
     * Get details of a transfer recipient on your integration.
     *
     * @link https://paystack.com/docs/api/#transfer-recipient-fetch
     */
    public function fetch(string $recipient_code): self
    {
        $this->get($this->url(self::ENDPOINT).'/'.$recipient_code);

        return $this;
    }

    /**
     * Update a transfer recipient details on your integration.
     *
     * @param  array<string, mixed>  $payload
     *
     * @link https://paystack.com/docs/api/#transfer-recipient-update
     */
    public function update(string $recipient_code, array $payload = []): self
    {
        $this->put($this->url(self::ENDPOINT).'/'.$recipient_code, $payload);

        return $this;
    }

    /**
     * Delete a transfer recipient (sets the transfer recipient to inactive).
     *
     * @link https://paystack.com/docs/api/#transfer-recipient-delete
     */
    public function deactivate(string $recipient_code): self
    {
        $this->delete($this->url(self::ENDPOINT).'/'.$recipient_code);

        return $this;
    }
}
