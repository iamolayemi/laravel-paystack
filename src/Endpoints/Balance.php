<?php

namespace Iamolayemi\Paystack\Endpoints;

class Balance extends Endpoint
{
    protected const ENDPOINT = '/balance';

    /**
     * Fetch the available balance.
     *
     * @link https://paystack.com/docs/api/#transfer-control-balance
     */
    public function check(): self
    {
        $this->get($this->url(self::ENDPOINT));

        return $this;
    }

    /**
     * Fetch all pay-ins and pay-outs that occurred on your integration.
     *
     * @link https://paystack.com/docs/api/#transfer-control-balance-ledger
     */
    public function ledger(): self
    {
        $this->get($this->url(self::ENDPOINT).'/ledger');

        return $this;
    }
}
