<?php

namespace Iamolayemi\Paystack\Endpoints;

class Country extends Endpoint
{
    protected const ENDPOINT = '/country';

    /**
     * Gets a list of Countries that Paystack currently supports.
     *
     * @link https://paystack.com/docs/api/#miscellaneous-bank
     */
    public function list(): self
    {
        $this->get($this->url(self::ENDPOINT));

        return $this;
    }

    /**
     * Get a list of states for a country for address verification.
     *
     * @link https://paystack.com/docs/api/#miscellaneous-avs-states
     */
    public function states(string $country_code): self
    {
        $this->get($this->url('/address_verification/states'), ['country' => $country_code]);

        return $this;
    }
}
