<?php

namespace Iamolayemi\Paystack\Tests\Unit;

use Iamolayemi\Paystack\Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Iamolayemi\Paystack\Facades\Paystack;

class CustomerEndpointTest extends TestCase
{
    private const CUSTOMER_EMAIL = 'bojack@horsinaround.com';
    private const CUSTOMER_CODE = 'CUS_xnxdt6s1zg1f4nx';

    /** @test */
    public function a_customer_can_be_created()
    {
        Http::fake(
            [
                'https://api.paystack.co/customer' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/customer/create_customer.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::customer()
            ->create([])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals("Customer created", $response['message']);
        $this->assertEquals("customer@email.com", $response['data']['email']);
    }

    /** @test */
    public function it_returns_a_list_of_customers()
    {
        Http::fake(
            [
                'https://api.paystack.co/customer' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/customer/list_customers.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::customer()
            ->list()->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Customers retrieved', $response['message']);
        $this->assertIsArray($response['data']);
    }

    /** @test */
    public function it_returns_the_details_of_a_customer()
    {
        Http::fake(
            [
                'https://api.paystack.co/customer/bojack@horsinaround.com' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/customer/fetch_customer.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::customer()
            ->fetch(self::CUSTOMER_EMAIL)->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Customer retrieved', $response['message']);
        $this->assertEquals(self::CUSTOMER_EMAIL, $response['data']['email']);
    }

    /** @test */
    public function a_customer_can_be_updated()
    {
        Http::fake(
            [
                'https://api.paystack.co/customer/CUS_xnxdt6s1zg1f4nx' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/customer/update_customer.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::customer()
            ->update(self::CUSTOMER_CODE, [])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals("Customer updated", $response['message']);
        $this->assertEquals(self::CUSTOMER_CODE, $response['data']['customer_code']);

    }

    /** @test */
    public function a_customer_can_be_identified()
    {
        Http::fake(
            [
                'https://api.paystack.co/customer/CUS_xnxdt6s1zg1f4nx/identification' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/customer/validate_customer.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::customer()->validate(self::CUSTOMER_CODE, [])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals("Customer Identification in progress", $response['message']);
    }

    /** @test */
    public function a_customer_can_be_whitelisted()
    {
        Http::fake(
            [
                'https://api.paystack.co/customer/set_risk_action' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/customer/whitelist_customer.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::customer()->whitelist([])->response();


        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals("Customer updated", $response['message']);
    }

    /** @test */
    public function a_customer_authorization_can_be_deactivated()
    {
        Http::fake(
            [
                'https://api.paystack.co/customer/deactivate_authorization' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/customer/deactivate_authorization.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::customer()->deactivateAuthorization([])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals("Authorization has been deactivated", $response['message']);
    }
}
