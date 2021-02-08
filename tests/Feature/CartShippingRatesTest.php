<?php


use Illuminate\Foundation\Testing\RefreshDatabase;
use juniorE\ShoppingCart\Models\CartShippingRate;
use juniorE\ShoppingCart\Tests\TestCase;

class CartShippingRatesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_make_a_shipping_rate(){
        $invoice = cart()->shippingRateRepository->addShippingRate([
            "method" => "invoice",
            "price" => 10,
            "minimum_cart_price" => 0
        ]);

        $cash = cart()->shippingRateRepository->addShippingRate([
            "method" => "cash",
            "price" => 0,
            "minimum_cart_price" => 0
        ]);

        $this->assertEquals("invoice", $invoice->method);
        $this->assertEquals("cash", $cash->method);

        $this->assertEquals(10, $invoice->price);
        $this->assertEquals(0, $cash->price);

        $this->assertCount(2, CartShippingRate::all());
    }
}
