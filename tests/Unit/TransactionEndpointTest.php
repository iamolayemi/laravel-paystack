<?php

namespace Iamolayemi\Paystack\Tests\Unit;

use Iamolayemi\Paystack\Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Iamolayemi\Paystack\Facades\Paystack;

class TransactionEndpointTest extends TestCase
{
    protected const TRANSACTION_REFERENCE = 'DG4uishudoq90LD';
    protected const TRANSACTION_ID = '292584114';

    /** @test */
    public function a_transaction_can_be_initialized()
    {
        Http::fake(
            [
                'https://api.paystack.co/transaction/initialize' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/transaction/initialize_transaction.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::transaction()
            ->initialize([])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals("Authorization URL created", $response['message']);
        $this->assertArrayHasKey('authorization_url', $response['data']);
    }

    /** @test */
    public function a_transaction_can_be_verified()
    {
        Http::fake(
            [
                'https://api.paystack.co/transaction/verify/DG4uishudoq90LD' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/transaction/verify_transaction.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::transaction()->verify(self::TRANSACTION_REFERENCE)->response();


        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals("Verification successful", $response['message']);
    }

    /** @test */
    public function it_returns_a_list_of_transactions()
    {
        Http::fake(
            [
                'https://api.paystack.co/transaction' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/transaction/list_transactions.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::transaction()
            ->list()->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Transactions retrieved', $response['message']);
    }

    /** @test */
    public function it_returns_the_details_of_a_transaction()
    {
        Http::fake(
            [
                'https://api.paystack.co/transaction/292584114' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/transaction/fetch_transaction.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );
        $response = Paystack::transaction()
            ->fetch(self::TRANSACTION_ID)->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Transaction retrieved', $response['message']);
        $this->assertEquals(self::TRANSACTION_ID, $response['data']['id']);
    }

    /** @test */
    public function an_authorization_can_be_charged()
    {
        Http::fake(
            [
                'https://api.paystack.co/transaction/charge_authorization' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/transaction/charge_authorization.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::transaction()
            ->chargeAuthorization([])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('success', $response['data']['status']);
        $this->assertEquals('Approved', $response['data']['gateway_response']);
    }

    /** @test */
    public function an_authorization_can_be_checked()
    {
        Http::fake(
            [
                'https://api.paystack.co/transaction/check_authorization' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/transaction/check_authorization.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );
        $response = Paystack::transaction()
            ->checkAuthorization([])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Authorization is valid for this amount', $response['message']);
    }


    /** @test */
    public function it_returns_transaction_timeline()
    {
        Http::fake(
            [
                'https://api.paystack.co/transaction/timeline/DG4uishudoq90LD' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/transaction/transaction_timeline.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::transaction()
            ->timeline(self::TRANSACTION_REFERENCE)->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Timeline retrieved', $response['message']);
    }

    /** @test */
    public function it_returns_transaction_totals()
    {
        Http::fake(
            [
                'https://api.paystack.co/transaction/totals' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/transaction/transaction_totals.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::transaction()
            ->totals()->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Transaction totals', $response['message']);
        $this->assertIsArray($response['data']);
    }


    /** @test */
    public function all_transactions_can_be_exported()
    {
        Http::fake(
            [
                'https://api.paystack.co/transaction/export' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/transaction/export_transactions.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );
        $response = Paystack::transaction()
            ->export()->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Export successful', $response['message']);
        $this->assertEquals('https://files.paystack.co/exports/100032/1460290758207.csv', $response['data']['path']);
    }

    /** @test */
    public function a_partial_debit_can_be_initiated()
    {
        Http::fake(
            [
                'https://api.paystack.co/transaction/partial_debit' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/transaction/partial_debit.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::transaction()
            ->partialDebit([])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('success', $response['data']['status']);
        $this->assertEquals('Approved', $response['data']['gateway_response']);
    }
}
