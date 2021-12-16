<?php

namespace Iamolayemi\Paystack\Tests\Unit;

use Iamolayemi\Paystack\Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Paystack;

class InvoiceEndpointTest extends TestCase
{
    private const INVOICE_ID = 3136406;

    /** @test */
    public function an_invoice_can_be_created()
    {
        Http::fake(
            [
                'https://api.paystack.co/paymentrequest' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/invoice/create_invoice.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::invoice()
            ->create([])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals("Payment request created", $response['message']);
    }

    /** @test */
    public function it_returns_a_list_of_invoices()
    {
        Http::fake(
            [
                'https://api.paystack.co/paymentrequest' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/invoice/list_invoices.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::invoice()
            ->list([])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Payment requests retrieved', $response['message']);
        $this->assertIsArray($response['data']);
    }

    /** @test */
    public function it_returns_the_details_of_an_invoice()
    {
        Http::fake(
            [
                'https://api.paystack.co/paymentrequest/3136406' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/invoice/fetch_invoice.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::invoice()
            ->fetch(self::INVOICE_ID)->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Payment request retrieved', $response['message']);
        $this->assertEquals(self::INVOICE_ID, $response['data']['id']);
    }

    /** @test */
    public function an_invoice_can_be_verify()
    {
        Http::fake(
            [
                'https://api.paystack.co/paymentrequest/verify/3136406' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/invoice/verify_invoice.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::invoice()
            ->verify(self::INVOICE_ID)->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Payment request retrieved', $response['message']);
        $this->assertEquals(self::INVOICE_ID, $response['data']['id']);
    }

    /** @test */
    public function an_invoice_notification_can_be_sent()
    {
        Http::fake(
            [
                'https://api.paystack.co/paymentrequest/notify/3136406' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/invoice/send_notification.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::invoice()
            ->notify(self::INVOICE_ID)->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals("Notification sent", $response['message']);
    }

    /** @test */
    public function it_returns_a_list_of_invoice_metrics()
    {
        Http::fake(
            [
                'https://api.paystack.co/paymentrequest/totals' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/invoice/invoice_totals.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::invoice()
            ->totals()->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals("Payment request totals", $response['message']);
        $this->assertIsArray($response['data']);
    }

    /** @test */
    public function an_invoice_can_be_finalized()
    {
        Http::fake(
            [
                'https://api.paystack.co/paymentrequest/finalize/3136406' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/invoice/finalize_invoice.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::invoice()
            ->finalize(self::INVOICE_ID)->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals("Payment request finalized", $response['message']);
        $this->assertEquals(self::INVOICE_ID, $response['data']['id']);
    }

    /** @test */
    public function an_invoice_can_be_updated()
    {
        Http::fake(
            [
                'https://api.paystack.co/paymentrequest/3136406' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/invoice/update_invoice.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::invoice()
            ->update(self::INVOICE_ID, [])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals("Payment request updated", $response['message']);
    }

    /** @test */
    public function an_invoice_can_be_archived()
    {
        Http::fake(
            [
                'https://api.paystack.co/paymentrequest/archive/3136406' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/invoice/archive_invoice.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::invoice()
            ->archive(self::INVOICE_ID)->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals("Payment request has been archived", $response['message']);
    }

}
