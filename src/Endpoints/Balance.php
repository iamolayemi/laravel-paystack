<?php

namespace Iamolayemi\Paystack\Endpoints;

class Balance extends Endpoint
{
    protected const ENDPOINT = '/balance';

    /**
     * Fetch the available balance.
     *
     * @return Balance
     * @link https://paystack.com/docs/api/#transfer-control-balance
     */
    public function check(): self
    {
        $this->get($this->url(self::ENDPOINT));
        return $this;
    }

    /**
     * Fetch all pay-ins and pay-outs that occured on your integration.
     *
     * @return Balance
     * @link https://paystack.com/docs/api/#transfer-control-balance-ledger
     */
    public function ledger(): self
    {
        $this->get($this->url(self::ENDPOINT). '/ledger');
        return $this;
    }
}
