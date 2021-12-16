<?php

namespace Iamolayemi\Paystack\Endpoints;

class Resolve extends Endpoint
{

    /**
     * Confirm an account belongs to the right customer.
     *
     * @param array $query
     * @return Resolve
     * @link https://paystack.com/docs/api/#verification-resolve-account
     */
    public function bank(array $query = []): self
    {
        $this->get($this->url('/bank/resolve'), $query);
        return $this;
    }

    /**
     * Check if an account number and BVN are linked.
     *
     * @param array $payload
     * @return Resolve
     * @link https://paystack.com/docs/api/#verification-match-bvn
     */
    public function bvn(array $payload = []): self
    {
        $this->post('/bvn/match', $payload);
        return $this;
    }

    /**
     * Get more information about a customer's card.
     *
     * @param string $card_bin
     * @return Resolve
     * @link https://paystack.com/docs/api/#verification-resolve-card
     */
    public function card(string $card_bin): self
    {
        $this->get('/decision/bin/'. $card_bin);
        return $this;
    }
}
