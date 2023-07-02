<?php

namespace Iamolayemi\Paystack\Tests\Unit;

use Iamolayemi\Paystack\Facades\Paystack;
use Iamolayemi\Paystack\Tests\TestCase;
use Illuminate\Support\Facades\Http;

class TransferEndpointTest extends TestCase
{
    private const TRANSFER_CODE = 'TRF_1ptvuv321ahaa7q';

    private const TRANSFER_REFERENCE = 'ref_demo';

    /** @test */
    public function a_transfer_can_be_initiated()
    {
        Http::fake(
            [
                'https://api.paystack.co/transfer' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/transfer/initiate_transfer.json'),
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::transfer()
            ->initiate([])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Transfer requires OTP to continue', $response['message']);
        $this->assertEquals(self::TRANSFER_CODE, $response['data']['transfer_code']);
    }

    /** @test */
    public function a_transfer_can_be_finalized()
    {
        Http::fake(
            [
                'https://api.paystack.co/transfer/finalize_transfer' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/transfer/finalize_transfer.json'),
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::transfer()
            ->finalize([])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Transfer has been queued', $response['message']);
        $this->assertEquals(self::TRANSFER_CODE, $response['data']['transfer_code']);
    }

    /** @test */
    public function a_bulk_transfer_can_be_initiated()
    {
        Http::fake(
            [
                'https://api.paystack.co/transfer/bulk' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/transfer/initiate_bulk_transfer.json'),
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::transfer()
            ->bulk([])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('2 transfers queued.', $response['message']);
        $this->assertIsArray($response['data']);
    }

    /** @test */
    public function it_returns_a_list_of_transfers()
    {
        Http::fake(
            [
                'https://api.paystack.co/transfer' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/transfer/list_transfers.json'),
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::transfer()
            ->list()->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Transfers retrieved', $response['message']);
        $this->assertIsArray($response['data']);
    }

    /** @test */
    public function it_returns_the_details_of_a_transfer()
    {
        Http::fake(
            [
                'https://api.paystack.co/transfer/TRF_1ptvuv321ahaa7q' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/transfer/fetch_transfer.json'),
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::transfer()
            ->fetch(self::TRANSFER_CODE)->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Transfer retrieved', $response['message']);
        $this->assertEquals(self::TRANSFER_CODE, $response['data']['transfer_code']);
    }

    /** @test */
    public function a_transfer_can_be_verified()
    {
        Http::fake(
            [
                'https://api.paystack.co/transfer/verify/ref_demo' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/transfer/verify_transfer.json'),
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::transfer()
            ->verify(self::TRANSFER_REFERENCE)->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Transfer retrieved', $response['message']);
        $this->assertEquals(self::TRANSFER_REFERENCE, $response['data']['reference']);
        $this->assertEquals('success', $response['data']['status']);
    }

    /** @test */
    public function a_transfer_otp_can_be_resend()
    {
        Http::fake(
            [
                'https://api.paystack.co/transfer/resend_otp' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/transfer/resend_otp.json'),
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::transfer()
            ->resendOtp([])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('OTP has been resent', $response['message']);
    }

    /** @test */
    public function transfer_otp_can_be_disabled()
    {
        Http::fake(
            [
                'https://api.paystack.co/transfer/disable_otp' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/transfer/disable_otp.json'),
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::transfer()
            ->disableOtp()->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('OTP has been sent to mobile number ending with 4321', $response['message']);
    }

    /** @test */
    public function a_transfer_can_otp_has_been_disabled()
    {
        Http::fake(
            [
                'https://api.paystack.co/transfer/disable_otp_finalize' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/transfer/disable_otp_finalize.json'),
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::transfer()
            ->disableOtpFinalize([])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('OTP requirement for transfers has been disabled', $response['message']);
    }

    /** @test */
    public function a_transfer_can_be_enabled()
    {
        Http::fake(
            [
                'https://api.paystack.co/transfer/enable_otp' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/transfer/enable_otp.json'),
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::transfer()
            ->enableOTP()->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('OTP requirement for transfers has been enabled', $response['message']);
    }
}
