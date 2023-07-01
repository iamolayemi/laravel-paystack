<?php

namespace Iamolayemi\Paystack\Tests\Unit;

use Iamolayemi\Paystack\Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Iamolayemi\Paystack\Facades\Paystack;

class ProductEndpointTest extends TestCase
{
    private const PRODUCT_ID = 526;

    /** @test */
    public function a_product_can_be_created()
    {
        Http::fake(
            [
                'https://api.paystack.co/product' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/product/create_product.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::product()
            ->create([])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals("Product successfully created", $response['message']);
        $this->assertEquals("Product One", $response['data']['name']);
        $this->assertEquals(500000, $response['data']['price']);
    }

    /** @test */
    public function it_returns_a_list_of_products()
    {
        Http::fake(
            [
                'https://api.paystack.co/product' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/product/list_products.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::product()
            ->list([])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Products retrieved', $response['message']);
        $this->assertIsArray($response['data']);
    }

    /** @test */
    public function it_returns_the_details_of_a_product()
    {
        Http::fake(
            [
                'https://api.paystack.co/product/526' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/product/fetch_product.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::product()
            ->fetch(self::PRODUCT_ID)->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals('Product retrieved', $response['message']);
        $this->assertEquals(self::PRODUCT_ID, $response['data']['id']);
    }

    /** @test */
    public function a_product_can_be_updated()
    {
        Http::fake(
            [
                'https://api.paystack.co/product/526' => Http::response(
                    json_decode(
                        file_get_contents('tests/stubs/endpoints/product/update_product.json'),
                        true
                    ),
                    200, ['Headers']
                )
            ]
        );

        $response = Paystack::product()
            ->update(self::PRODUCT_ID, [])->response();

        Http::assertSentCount(1);
        $this->assertTrue($response['status']);
        $this->assertEquals("Product successfully updated", $response['message']);
        $this->assertEquals(self::PRODUCT_ID, $response['data']['id']);
    }

   }
