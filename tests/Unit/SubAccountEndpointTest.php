<?php

namespace Iamolayemi\Paystack\Tests\Unit;

use Iamolayemi\Paystack\Facades\Paystack;
use Iamolayemi\Paystack\Tests\TestCase;
use Illuminate\Support\Facades\Http;

class SubAccountEndpointTest extends TestCase
{
    private const SUBACCOUNT_ID = 55;

    /** @test */
    public function a_subaccount_can_be_created()
    {
        Http::fake(
            [
                'https://api.paystack.co/subaccount' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/subaccount/create_subaccount.json'),
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::subAccount()
            ->create([])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Subaccount created', $response['message']);
        $this->assertEquals('Sunshine Studios', $response['data']['business_name']);
        $this->assertEquals('0193274682', $response['data']['account_number']);

    }

    /** @test */
    public function it_returns_a_list_of_subaccounts()
    {
        Http::fake(
            [
                'https://api.paystack.co/subaccount' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/subaccount/list_subaccounts.json'),
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::subAccount()
            ->list()->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Subaccounts retrieved', $response['message']);
        $this->assertIsArray($response['data']);
    }

    /** @test */
    public function it_returns_the_details_of_a_subAccount()
    {
        Http::fake(
            [
                'https://api.paystack.co/subaccount/55' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/subaccount/fetch_subaccount.json'),
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::subAccount()
            ->fetch(self::SUBACCOUNT_ID)->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Subaccount retrieved', $response['message']);
        $this->assertEquals(self::SUBACCOUNT_ID, $response['data']['id']);
    }

    /** @test */
    public function a_subaccount_can_be_updated()
    {
        Http::fake(
            [
                'https://api.paystack.co/subaccount/55' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/subaccount/update_subaccount.json'),
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::subAccount()
            ->update(self::SUBACCOUNT_ID, [])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Subaccount updated', $response['message']);
        $this->assertEquals(self::SUBACCOUNT_ID, $response['data']['id']);
    }
}
