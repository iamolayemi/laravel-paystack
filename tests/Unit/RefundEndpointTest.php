<?php

namespace Iamolayemi\Paystack\Tests\Unit;

use Iamolayemi\Paystack\Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Paystack;

class RefundEndpointTest extends TestCase
{
    private const TRANSACTION_REFERENCE = 'x7g15k5iye';

    /** @test */
    public function a_refund_can_be_created()
    {
        Http::fake(
            [
                'https://api.paystack.co/refund' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/refund/create_refund.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::refund()
            ->create([])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals("Refund created", $response['message']);
        $this->assertEquals("x7g15k5iye", $response['data']['transaction']['reference']);
    }

    /** @test */
    public function it_returns_a_list_of_refunds()
    {
        Http::fake(
            [
                'https://api.paystack.co/refund' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/refund/list_refunds.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::refund()
            ->list()->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Refunds retrieved', $response['message']);
        $this->assertIsArray($response['data']);
    }

    /** @test */
    public function it_returns_the_details_of_a_refund()
    {
        Http::fake(
            [
                'https://api.paystack.co/refund/x7g15k5iye' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/refund/fetch_refund.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::refund()
            ->fetch(self::TRANSACTION_REFERENCE)->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Refund retrieved', $response['message']);
    }

}
