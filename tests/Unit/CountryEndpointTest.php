<?php

namespace Iamolayemi\Paystack\Tests\Unit;

use Iamolayemi\Paystack\Facades\Paystack;
use Iamolayemi\Paystack\Tests\TestCase;
use Illuminate\Support\Facades\Http;

class CountryEndpointTest extends TestCase
{
    /** @test */
    public function it_returns_a_list_of_countries()
    {
        Http::fake(
            [
                'https://api.paystack.co/country' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/country/list_countries.json'),
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::country()
            ->list()->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Countries retrieved', $response['message']);
        $this->assertIsArray($response['data']);
    }

    /** @test */
    public function it_returns_a_list_of_nuban_providers()
    {
        Http::fake(
            [
                'https://api.paystack.co/address_verification/states?country=CA' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/country/list_country_states.json'),
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::country()
            ->states('CA')->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('States retrieved', $response['message']);
        $this->assertIsArray($response['data']);
    }
}
