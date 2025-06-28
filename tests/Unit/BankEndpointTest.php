<?php

namespace Iamolayemi\Paystack\Tests\Unit;

use Iamolayemi\Paystack\Facades\Paystack;
use Iamolayemi\Paystack\Tests\TestCase;
use Illuminate\Support\Facades\Http;

class BankEndpointTest extends TestCase
{
    /** @test */
    public function it_returns_a_list_of_banks()
    {
        $json = file_get_contents('tests/stubs/endpoints/bank/list_banks.json');
        if ($json === false) {
            throw new \RuntimeException('Failed to read stub file: tests/stubs/endpoints/bank/list_banks.json');
        }
        Http::fake([
            'https://api.paystack.co/bank' => Http::response(
                json_decode(
                    $json,
                    true
                ),
                200, ['Headers']
            ),
        ]);

        $response = Paystack::bank()
            ->list([])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Banks retrieved', $response['message']);
        $this->assertIsArray($response['data']);
    }
}
