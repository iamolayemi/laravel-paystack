<?php

namespace Iamolayemi\Paystack\Endpoints;

class Product extends Endpoint
{

    protected const ENDPOINT = '/product';

    /**
     * Create a product on your integration.
     *
     * @param array $payload
     * @return Product
     * @link https://paystack.com/docs/api/#product-create
     */
    public function create(array $payload): self
    {
        $this->post($this->url(self::ENDPOINT), $payload);
        return $this;
    }

    /**
     * List products available on your integration.
     *
     * @param array $query
     * @return Product
     * @link https://paystack.com/docs/api/#product-list
     */
    public function list(array $query = []): self
    {
        $this->get($this->url(self::ENDPOINT), $query);
        return $this;
    }

    /**
     * Get details of a product on your integration.
     *
     * @param string $product_id
     * @return Product
     * @link https://paystack.com/docs/api/#product-fetch
     */
    public function fetch(string $product_id): self
    {
        $this->get($this->url(self::ENDPOINT) . '/' . $product_id);
        return $this;
    }

    /**
     * Update a product details on your integration.
     *
     * @param string $product_id
     * @param array $payload
     * @return Product
     * @link https://paystack.com/docs/api/#product-update
     */
    public function update(string $product_id, array $payload = []): self
    {
        $this->put($this->url(self::ENDPOINT) . '/' . $product_id, $payload);
        return $this;
    }
}
