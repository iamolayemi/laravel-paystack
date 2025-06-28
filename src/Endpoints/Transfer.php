<?php

namespace Iamolayemi\Paystack\Endpoints;

class Transfer extends Endpoint
{
    protected const ENDPOINT = '/transfer';

    /**
     * Initiate a transfer.
     *
     * @param  array<string, mixed>  $payload
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
     * @param  array<string, mixed>  $payload
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
     * @param  array<string, mixed>  $payload
     *
     * @link https://paystack.com/docs/api/#transfer-bulk
     */
    public function bulk(array $payload): self
    {
        $this->post($this->url(self::ENDPOINT).'/bulk', $payload);

        return $this;
    }

    /**
     * List transfers made on your integration.
     *
     * @param  array<string, mixed>  $query
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
     * Verify a transfer on your integration.
     *
     * @link https://paystack.com/docs/api/#transfer-verify
     */
    public function verify(string $transfer_code): self
    {
        $this->get($this->url(self::ENDPOINT).'/verify/'.$transfer_code);

        return $this;
    }

    /**
     * Resend OTP for a transfer.
     *
     * @param  array<string, mixed>  $payload
     *
     * @link https://paystack.com/docs/api/#transfer-resend-otp
     */
    public function resendOtp(array $payload): self
    {
        $this->post($this->url(self::ENDPOINT).'/resend_otp', $payload);

        return $this;
    }

    /**
     * Disable OTP requirement for transfers.
     *
     * @param  array<string, mixed>  $payload
     *
     * @link https://paystack.com/docs/api/#transfer-disable-otp
     */
    public function disableOtp(array $payload): self
    {
        $this->post($this->url(self::ENDPOINT).'/disable_otp', $payload);

        return $this;
    }

    /**
     * Finalize the request to disable OTP on your transfers.
     *
     * @param  array<string, mixed>  $payload
     *
     * @link https://paystack.com/docs/api/#transfer-disable-otp-finalize
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
