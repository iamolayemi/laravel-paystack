<?php

namespace Iamolayemi\Paystack\Tests\Unit;

use Iamolayemi\Paystack\Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Paystack;

class TransferRecipentTest extends TestCase
{
    private const RECIPENT_CODE = 'RCP_2x5j67tnnw1t98k';

    /** @test */
    public function a_recipent_can_be_created()
    {
        Http::fake(
            [
                'https://api.paystack.co/transferrecipient' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/transferrecipient/create_recipent.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::recipent()
            ->create([])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals("Recipient created", $response['message']);
        $this->assertArrayHasKey("recipient_code", $response['data']);
        $this->assertEquals("0100000010", $response['data']['details']['account_number']);
    }

    /** @test */
    public function a_bulk_recipent_can_be_created()
    {
        Http::fake(
            [
                'https://api.paystack.co/transferrecipient/bulk' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/transferrecipient/create_bulk_recipent.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = paystack()->recipent()
            ->createBulk([])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals("Recipients added successfully", $response['message']);
        $this->assertIsArray($response['data']);
    }

    /** @test */
    public function it_returns_a_list_of_recipents()
    {
        Http::fake(
            [
                'https://api.paystack.co/transferrecipient' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/transferrecipient/list_recipents.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::recipent()
            ->list()->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Recipients retrieved', $response['message']);
        $this->assertIsArray($response['data']);
    }

    /** @test */
    public function it_returns_the_details_of_a_recipent()
    {
        Http::fake(
            [
                'https://api.paystack.co/transferrecipient/RCP_2x5j67tnnw1t98k' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/transferrecipient/fetch_recipent.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = paystack()->recipent()
            ->fetch(self::RECIPENT_CODE)->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Recipient retrieved', $response['message']);
        $this->assertEquals(self::RECIPENT_CODE, $response['data']['recipient_code']);
    }

    /** @test */
    public function a_recipent_can_be_updated()
    {
        Http::fake(
            [
                'https://api.paystack.co/transferrecipient/RCP_2x5j67tnnw1t98k' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/transferrecipient/update_recipent.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::recipent()
            ->update(self::RECIPENT_CODE, [])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals("Recipient updated", $response['message']);
        $this->assertEquals(self::RECIPENT_CODE, $response['data']['recipient_code']);
    }

    /** @test */
    public function a_recipent_can_be_deactivated()
    {
        Http::fake(
            [
                'https://api.paystack.co/transferrecipient/RCP_2x5j67tnnw1t98k' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/transferrecipient/delete_recipent.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::recipent()->deactivate(self::RECIPENT_CODE)->response();


        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals("Transfer recipient set as inactive", $response['message']);
    }

}
