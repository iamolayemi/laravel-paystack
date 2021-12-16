<?php

namespace Iamolayemi\Paystack\Tests\Unit;

use Iamolayemi\Paystack\Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Paystack;

class DedicateAccountEndpointTest extends TestCase
{

    private const ACCOUNT_ID = 59;

    /** @test */
    public function a_dedicated_account_can_be_created()
    {
        Http::fake(
            [
                'https://api.paystack.co/dedicated_account' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/dedicatedaccount/create_dedicated_account.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );


        $response = Paystack::dedicatedAccount()
            ->create([])->response();


        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals("NUBAN successfully created", $response['message']);
        $this->assertEquals("9930000737", $response['data']['account_number']);
    }

    /** @test */
    public function it_returns_a_list_of_dedicated_accounts()
    {
        Http::fake(
            [
                'https://api.paystack.co/dedicated_account' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/dedicatedaccount/list_dedicated_accounts.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::dedicatedAccount()
            ->list([])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Managed accounts successfully retrieved', $response['message']);
        $this->assertIsArray($response['data']);
    }

    /** @test */
    public function it_returns_the_details_of_a_dedicatedaccount()
    {
        Http::fake(
            [
                'https://api.paystack.co/dedicated_account/59' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/dedicatedaccount/fetch_dedicated_account.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::dedicatedaccount()
            ->fetch(self::ACCOUNT_ID)->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Customer retrieved', $response['message']);
        $this->assertEquals(self::ACCOUNT_ID, $response['data']['dedicated_account']['id']);
    }

    /** @test */
    public function a_dedicatedaccount_can_be_deactivated()
    {
        Http::fake(
            [
                'https://api.paystack.co/dedicated_account/59' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/dedicatedaccount/deactivate_dedicated_account.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::dedicatedaccount()
            ->deactivate(self::ACCOUNT_ID, [])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals("Managed Account Successfully Unassigned", $response['message']);
        $this->assertEquals(self::ACCOUNT_ID, $response['data']['id']);
    }

    /** @test */
    public function a_split_dedicated_transaction_can_be_created()
    {
        Http::fake(
            [
                'https://api.paystack.co/dedicated_account/split' => Http::response(
                    json_decode(
                        file_get_contents(
                            'tests/stubs/endpoints/dedicatedaccount/create_split_transaction_account.json'
                        ),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );


        $response = Paystack::dedicatedAccount()
            ->addSplit([])->response();


        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals("Assigned Managed Account Successfully Created", $response['message']);
        $this->assertEquals(self::ACCOUNT_ID, $response['data']['id']);
    }

    /** @test */
    public function a_split_dedicated_transaction_can_be_deleted()
    {
        Http::fake(
            [
                'https://api.paystack.co/dedicated_account/split' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/dedicatedaccount/delete_split_transaction_account.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::dedicatedAccount()
            ->removeSplit([])->response();

        Http::assertSentCount(1);
        $this->assertEquals('success', $response['status']);
        $this->assertEquals('Subaccount unassigned', $response['message']);
        $this->assertIsArray($response['data']);
    }

    /** @test */
    public function it_returns_a_list_of_bank_providers()
    {
        Http::fake(
            [
                'https://api.paystack.co/dedicated_account/available_providers' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/dedicatedaccount/list_account_providers.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::dedicatedAccount()
            ->providers()->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Dedicated account providers retrieved', $response['message']);
        $this->assertIsArray($response['data']);
    }

}
