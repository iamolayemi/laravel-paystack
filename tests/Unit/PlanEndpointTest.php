<?php

namespace Iamolayemi\Paystack\Tests\Unit;

use Iamolayemi\Paystack\Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Paystack;

class PlanEndpointTest extends TestCase
{
    private const PLAN_CODE = 'PLN_gx2wn530m0i3w3m';

    /** @test */
    public function a_plan_can_be_created()
    {
        Http::fake(
            [
                'https://api.paystack.co/plan' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/plan/create_plan.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::plan()
            ->create([])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals("Plan created", $response['message']);
        $this->assertEquals("Monthly retainer", $response['data']['name']);
        $this->assertEquals(500000, $response['data']['amount']);
    }

    /** @test */
    public function it_returns_a_list_of_plans()
    {
        Http::fake(
            [
                'https://api.paystack.co/plan' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/plan/list_plans.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::plan()
            ->list()->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Plans retrieved', $response['message']);
        $this->assertIsArray($response['data']);
    }

    /** @test */
    public function it_returns_the_details_of_a_plan()
    {
        Http::fake(
            [
                'https://api.paystack.co/plan/PLN_gx2wn530m0i3w3m' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/plan/fetch_plan.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::plan()
            ->fetch(self::PLAN_CODE)->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Plan retrieved', $response['message']);
        $this->assertEquals(self::PLAN_CODE, $response['data']['plan_code']);
    }

    /** @test */
    public function a_plan_can_be_updated()
    {
        Http::fake(
            [
                'https://api.paystack.co/plan/PLN_gx2wn530m0i3w3m' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/plan/update_plan.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::plan()
            ->update(self::PLAN_CODE, [])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals("Plan updated. 1 subscription(s) affected", $response['message']);
     }

   }
