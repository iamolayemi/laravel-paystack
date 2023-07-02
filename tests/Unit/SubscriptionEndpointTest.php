<?php

namespace Iamolayemi\Paystack\Tests\Unit;

use Iamolayemi\Paystack\Facades\Paystack;
use Iamolayemi\Paystack\Tests\TestCase;
use Illuminate\Support\Facades\Http;

class SubscriptionEndpointTest extends TestCase
{
    private const SUBSCRIPTION_CODE = 'SUB_vsyqdmlzble3uii';

    /** @test */
    public function a_subscription_can_be_created()
    {
        Http::fake(
            [
                'https://api.paystack.co/subscription' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/subscription/create_subscription.json'),
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::subscription()
            ->create([])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Subscription successfully created', $response['message']);
        $this->assertEquals('SUB_vsyqdmlzble3uii', $response['data']['subscription_code']);
    }

    /** @test */
    public function it_returns_a_list_of_subscriptions()
    {
        Http::fake(
            [
                'https://api.paystack.co/subscription' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/subscription/list_subscriptions.json'),
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::subscription()
            ->list()->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Subscriptions retrieved', $response['message']);
        $this->assertIsArray($response['data']);
    }

    /** @test */
    public function it_returns_the_details_of_a_subscription()
    {
        Http::fake(
            [
                'https://api.paystack.co/subscription/SUB_vsyqdmlzble3uii' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/subscription/fetch_subscription.json'),
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::subscription()
            ->fetch(self::SUBSCRIPTION_CODE)->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Subscription retrieved successfully', $response['message']);
        $this->assertEquals(self::SUBSCRIPTION_CODE, $response['data']['subscription_code']);
    }

    /** @test */
    public function a_subscription_can_be_enabled()
    {
        Http::fake(
            [
                'https://api.paystack.co/subscription/enable' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/subscription/enable_subscription.json'),
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::subscription()
            ->enable([])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Subscription enabled successfully', $response['message']);
    }

    /** @test */
    public function a_subscription_can_be_disabled()
    {
        Http::fake(
            [
                'https://api.paystack.co/subscription/disable' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/subscription/disable_subscription.json'),
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::subscription()
            ->disable([])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Subscription disabled successfully', $response['message']);
    }
}
