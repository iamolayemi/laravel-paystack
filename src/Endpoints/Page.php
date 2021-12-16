<?php

namespace Iamolayemi\Paystack\Endpoints;

class Page extends Endpoint
{

    protected const ENDPOINT = '/page';

    /**
     * Create a payment page on your integration.
     *
     * @param array $payload
     * @return Page
     * @link https://paystack.com/docs/api/#page-create
     */
    public function create(array $payload): self
    {
        $this->post($this->url(self::ENDPOINT), $payload);
        return $this;
    }

    /**
     * List payment pages available on your integration.
     *
     * @param array $query
     * @return Page
     * @link https://paystack.com/docs/api/#page-list
     */
    public function list(array $query = []): self
    {
        $this->get($this->url(self::ENDPOINT), $query);
        return $this;
    }

    /**
     * Get details of a page on your integration.
     *
     * @param string $page_id
     * @return Page
     * @link https://paystack.com/docs/api/#page-fetch
     */
    public function fetch(string $page_id): self
    {
        $this->get($this->url(self::ENDPOINT) . '/' . $page_id);
        return $this;
    }

    /**
     * Update a page details on your integration.
     *
     * @param string $page_id
     * @param array $payload
     * @return Page
     * @link https://paystack.com/docs/api/#page-update
     */
    public function update(string $page_id, array $payload = []): self
    {
        $this->put($this->url(self::ENDPOINT) . '/' . $page_id, $payload);
        return $this;
    }

    /**
     * Check the availability of a slug for a payment page.
     *
     * @param string $slug
     * @return Page
     * @link https://paystack.com/docs/api/#page-check-slug
     */
    public function checkAvailability(string $slug): self
    {
        $this->get($this->url(self::ENDPOINT) . '/check_slug_availability/' . $slug);
        return $this;
    }

    /**
     * Check the availability of a slug for a payment page.
     *
     * @param int $page_id
     * @param array $payload
     * @return Page
     * @link https://paystack.com/docs/api/#page-add-products
     */
    public function addProduct(int $page_id, array $payload = []): self
    {
        $this->post($this->url(self::ENDPOINT) . '/' .$page_id. '/product', $payload);
        return $this;
    }
}
