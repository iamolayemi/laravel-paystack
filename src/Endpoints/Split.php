<?php

namespace Iamolayemi\Paystack\Endpoints;

class Split extends Endpoint
{
    public const ENDPOINT = '/split';

    /**
     * Create a split payment on your integration
     *
     * @param array $payload
     * @return Split
     * @link https://paystack.com/docs/api/#split-create
     */
    public function create(array $payload): self
    {
        $this->post($this->url(self::ENDPOINT), $payload);
        return $this;
    }

    /**
     * List/search for the transaction splits available on your integration.
     *
     * @param array $query
     * @return Split
     * @link https://paystack.com/docs/api/#split-list
     */
    public function list(array $query = []): self
    {
        $this->get($this->url(self::ENDPOINT), $query);
        return $this;
    }

    /**
     * Get details of a split on your integration.
     *
     * @param string $split_id
     * @return Split
     * @link https://paystack.com/docs/api/#split-fetch
     */
    public function fetch(string $split_id): self
    {
        $this->get($this->url(self::ENDPOINT) . '/' . $split_id);
        return $this;
    }

    /**
     * Update a transaction split details on your integration.
     *
     * @param string $split_id
     * @param array $payload
     * @return Split
     * @link https://paystack.com/docs/api/#split-update
     */
    public function update(string $split_id, array $payload = []): self
    {
        $this->put($this->url(self::ENDPOINT) . '/' . $split_id, $payload);
        return $this;
    }

    /**
     * Add a Subaccount to a Transaction Split,
     * or update the share of an existing Subaccount in a Transaction Split
     *
     * @param string $split_id
     * @param array $payload
     * @return Split
     * @link https://paystack.com/docs/api/#split-add-subaccount
     */
    public function addSubaccount(string $split_id, array $payload = []): self
    {
        $this->post($this->url(self::ENDPOINT) . '/' . $split_id . '/subaccount/add', $payload);
        return $this;
    }

    /**
     * Remove a subaccount from a transaction split.
     *
     * @param string $split_id
     * @param array $payload
     * @return Split
     * @link https://paystack.com/docs/api/#split-remove-subaccount
     */
    public function removeSubaccount(string $split_id, array $payload = []): self
    {
        $this->post($this->url(self::ENDPOINT) . '/' . $split_id . '/subaccount/remove', $payload);
        return $this;
    }
}
