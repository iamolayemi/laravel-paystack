<?php

namespace Iamolayemi\Paystack\Tests\Unit;

use Iamolayemi\Paystack\Facades\Paystack;
use Iamolayemi\Paystack\Tests\TestCase;
use Illuminate\Support\Facades\Http;

class BalanceEndpointTest extends TestCase
{
    /** @test */
    public function it_returns_account_balances()
    {
        Http::fake(
            [
                'https://api.paystack.co/balance' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/balance/check_balance.json'),
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::balance()
            ->check()->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Balances retrieved', $response['message']);
        $this->assertIsArray($response['data']);
    }

    /** @test */
    public function it_returns_balance_ledger()
    {
        Http::fake(
            [
                'https://api.paystack.co/balance/ledger' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/balance/fetch_ledger_balance.json'),
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::balance()
            ->ledger()->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Balance ledger retrieved', $response['message']);
        $this->assertIsArray($response['data']);
    }
}
