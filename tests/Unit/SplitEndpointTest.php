<?php

namespace Iamolayemi\Paystack\Tests\Unit;

use Iamolayemi\Paystack\Facades\Paystack;
use Iamolayemi\Paystack\Tests\TestCase;
use Illuminate\Support\Facades\Http;

class SplitEndpointTest extends TestCase
{
    const SPLIT_ID = '12345';

    /** @test */
    public function a_split_payment_can_be_created()
    {
        Http::fake(
            [
                'https://api.paystack.co/split' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/split/create_split.json'),
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::split()
            ->create([])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertIsArray($response['data']);
        $this->assertEquals('Split created', $response['message']);
    }

    /** @test */
    public function it_returns_a_list_of_splits()
    {
        Http::fake(
            [
                'https://api.paystack.co/split' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/split/list_splits.json'),
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::split()
            ->list([])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Split retrieved', $response['message']);
        $this->assertEquals('SPL_UO2vBzEqHW', $response['data'][0]['split_code']);
    }

    /** @test */
    public function it_returns_the_details_of_a_split()
    {
        Http::fake(
            [
                'https://api.paystack.co/split/12345' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/split/fetch_split.json'),
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::split()
            ->fetch(self::SPLIT_ID)->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Split retrieved', $response['message']);
        $this->assertEquals(self::SPLIT_ID, $response['data']['id']);
    }

    /** @test */
    public function a_split_group_can_be_updated()
    {
        Http::fake(
            [
                'https://api.paystack.co/split/12345' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/split/update_split.json'),
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::split()
            ->update(self::SPLIT_ID, [])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Split group updated', $response['message']);
        $this->assertEquals(self::SPLIT_ID, $response['data']['id']);
    }

    /** @test */
    public function a_subaccount_can_be_added_to_split()
    {
        Http::fake(
            [
                'https://api.paystack.co/split/12345/subaccount/add' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/split/add_subaccount.json'),
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::split()
            ->addSubaccount(self::SPLIT_ID, [])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Subaccount added', $response['message']);
        $this->assertEquals(self::SPLIT_ID, $response['data']['id']);
    }

    /** @test */
    public function a_subaccount_can_be_removed_from_a_split()
    {
        Http::fake(
            [
                'https://api.paystack.co/split/12345/subaccount/remove' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/split/remove_subaccount.json'),
                        true
                    ),
                    200, ['Headers']
                ),
            ]
        );

        $response = Paystack::split()
            ->removeSubaccount(self::SPLIT_ID, [])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Subaccount removed', $response['message']);
    }
}
