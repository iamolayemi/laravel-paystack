<?php

namespace Iamolayemi\Paystack\Tests\Unit;

use Iamolayemi\Paystack\Facades\Paystack;
use Iamolayemi\Paystack\Tests\TestCase;
use Illuminate\Support\Facades\Http;

class InvoiceEndpointTest extends TestCase
{
    private const INVOICE_ID = 3136406;

    /** @test */
    public function an_invoice_can_be_created()
    {
        $json = file_get_contents('tests/stubs/endpoints/invoice/create_invoice.json');
        if ($json === false) {
            throw new \RuntimeException('Failed to read stub file: tests/stubs/endpoints/invoice/create_invoice.json');
        }
        Http::fake(
            [
                'https://api.paystack.co/paymentrequest' => Http::response(
                    json_decode(
                        $json,
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::invoice()
            ->create([])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Payment request created', $response['message']);
    }

    /** @test */
    public function it_returns_a_list_of_invoices()
    {
        $json = file_get_contents('tests/stubs/endpoints/invoice/list_invoices.json');
        if ($json === false) {
            throw new \RuntimeException('Failed to read stub file: tests/stubs/endpoints/invoice/list_invoices.json');
        }
        Http::fake(
            [
                'https://api.paystack.co/paymentrequest' => Http::response(
                    json_decode(
                        $json,
                        true
                    ),
                    200, ['Headers']
                ),
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
        $json = file_get_contents('tests/stubs/endpoints/invoice/fetch_invoice.json');
        if ($json === false) {
            throw new \RuntimeException('Failed to read stub file: tests/stubs/endpoints/invoice/fetch_invoice.json');
        }
        Http::fake(
            [
                'https://api.paystack.co/paymentrequest/3136406' => Http::response(
                    json_decode(
                        $json,
                        true
                    ),
                    200, ['Headers']
                ),
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
        $json = file_get_contents('tests/stubs/endpoints/invoice/verify_invoice.json');
        if ($json === false) {
            throw new \RuntimeException('Failed to read stub file: tests/stubs/endpoints/invoice/verify_invoice.json');
        }
        Http::fake(
            [
                'https://api.paystack.co/paymentrequest/verify/3136406' => Http::response(
                    json_decode(
                        $json,
                        true
                    ),
                    200, ['Headers']
                ),
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
        $json = file_get_contents('tests/stubs/endpoints/invoice/send_notification.json');
        if ($json === false) {
            throw new \RuntimeException('Failed to read stub file: tests/stubs/endpoints/invoice/send_notification.json');
        }
        Http::fake(
            [
                'https://api.paystack.co/paymentrequest/notify/3136406' => Http::response(
                    json_decode(
                        $json,
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::invoice()
            ->notify(self::INVOICE_ID)->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Notification sent', $response['message']);
    }

    /** @test */
    public function it_returns_a_list_of_invoice_metrics()
    {
        $json = file_get_contents('tests/stubs/endpoints/invoice/invoice_totals.json');
        if ($json === false) {
            throw new \RuntimeException('Failed to read stub file: tests/stubs/endpoints/invoice/invoice_totals.json');
        }
        Http::fake(
            [
                'https://api.paystack.co/paymentrequest/totals' => Http::response(
                    json_decode(
                        $json,
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::invoice()
            ->totals()->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Payment request totals', $response['message']);
        $this->assertIsArray($response['data']);
    }

    /** @test */
    public function an_invoice_can_be_finalized()
    {
        $json = file_get_contents('tests/stubs/endpoints/invoice/finalize_invoice.json');
        if ($json === false) {
            throw new \RuntimeException('Failed to read stub file: tests/stubs/endpoints/invoice/finalize_invoice.json');
        }
        Http::fake(
            [
                'https://api.paystack.co/paymentrequest/finalize/3136406' => Http::response(
                    json_decode(
                        $json,
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::invoice()
            ->finalize(self::INVOICE_ID)->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Payment request finalized', $response['message']);
        $this->assertEquals(self::INVOICE_ID, $response['data']['id']);
    }

    /** @test */
    public function an_invoice_can_be_updated()
    {
        $json = file_get_contents('tests/stubs/endpoints/invoice/update_invoice.json');
        if ($json === false) {
            throw new \RuntimeException('Failed to read stub file: tests/stubs/endpoints/invoice/update_invoice.json');
        }
        Http::fake(
            [
                'https://api.paystack.co/paymentrequest/3136406' => Http::response(
                    json_decode(
                        $json,
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::invoice()
            ->update(self::INVOICE_ID, [])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Payment request updated', $response['message']);
    }

    /** @test */
    public function an_invoice_can_be_archived()
    {
        $json = file_get_contents('tests/stubs/endpoints/invoice/archive_invoice.json');
        if ($json === false) {
            throw new \RuntimeException('Failed to read stub file: tests/stubs/endpoints/invoice/archive_invoice.json');
        }
        Http::fake([
            'https://api.paystack.co/paymentrequest/archive/3136406' => Http::response(
                json_decode(
                    $json,
                    true
                ),
                200, ['Headers']
            ),
        ]);

        $response = Paystack::invoice()
            ->archive(self::INVOICE_ID)->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Payment request has been archived', $response['message']);
    }
}
