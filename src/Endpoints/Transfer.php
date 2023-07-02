<?php

namespace Iamolayemi\Paystack\Endpoints;

class Transfer extends Endpoint
{
    protected const ENDPOINT = '/transfer';

    /**
     * Initiate a transfer.
     *
     * @link https://paystack.com/docs/api/#transfer-initiate
     */
    public function initiate(array $payload): self
    {
        $this->post($this->url(self::ENDPOINT), $payload);

        return $this;
    }

    /**
     * Finalize an initiated transfer.
     *
     * @link https://paystack.com/docs/api/#transfer-finalize
     */
    public function finalize(array $payload): self
    {
        $this->post($this->url(self::ENDPOINT).'/finalize_transfer', $payload);

        return $this;
    }

    /**
     * Initiate a bulk transfer.
     *
     * @link https://paystack.com/docs/api/#transfer-bulk
     */
    public function bulk(array $payload): self
    {
        $this->post($this->url(self::ENDPOINT).'/bulk', $payload);

        return $this;
    }

    /**
     * List the transfers made on your integration.
     *
     * @link https://paystack.com/docs/api/#transfer-list
     */
    public function list(array $query = []): self
    {
        $this->get($this->url(self::ENDPOINT), $query);

        return $this;
    }

    /**
     * Get details of a transfer on your integration.
     *
     * @link https://paystack.com/docs/api/#transfer-fetch
     */
    public function fetch(string $transfer_code): self
    {
        $this->get($this->url(self::ENDPOINT).'/'.$transfer_code);

        return $this;
    }

    /**
     * Verify the status of a transfer on your integration.
     *
     * @link https://paystack.com/docs/api/#transfer-verify
     */
    public function verify(string $reference): self
    {
        $this->get($this->url(self::ENDPOINT).'/verify/'.$reference);

        return $this;
    }

    /**
     * Generates a new OTP and sends to customer.
     *
     * @link https://paystack.com/docs/api/#transfer-control-resend-otp
     */
    public function resendOtp(array $payload): self
    {
        $this->post($this->url(self::ENDPOINT).'/resend_otp', $payload);

        return $this;
    }

    /**
     * Disable OTP.
     *
     * @link https://paystack.com/docs/api/#transfer-control-disable-otp
     */
    public function disableOtp(): self
    {
        $this->post($this->url(self::ENDPOINT).'/disable_otp');

        return $this;
    }

    /**
     * Finalize the request to disable OTP on your transfer.
     *
     * @link https://paystack.com/docs/api/#transfer-control-finalize-disable-otp
     */
    public function disableOtpFinalize(array $payload): self
    {
        $this->post($this->url(self::ENDPOINT).'/disable_otp_finalize', $payload);

        return $this;
    }

    /**
     * Enable OTP.
     *
     * @link https://paystack.com/docs/api/#transfer-control-enable-otp
     */
    public function enableOtp(): self
    {
        $this->post($this->url(self::ENDPOINT).'/enable_otp');

        return $this;
    }
}
