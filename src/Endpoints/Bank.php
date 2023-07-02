<?php

namespace Iamolayemi\Paystack\Endpoints;

class Bank extends Endpoint
{
    protected const ENDPOINT = '/bank';

    /**
     * Get a list of all supported banks and their properties.
     *
     * @link https://paystack.com/docs/api/#miscellaneous-bank
     */
    public function list(array $query = []): self
    {
        $this->get($this->url(self::ENDPOINT), $query);

        return $this;
    }
}
