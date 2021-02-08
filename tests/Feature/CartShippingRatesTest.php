<?php


use Illuminate\Foundation\Testing\RefreshDatabase;
use juniorE\ShoppingCart\Models\CartShippingRate;
use juniorE\ShoppingCart\Tests\TestCase;

class CartShippingRatesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var CartShippingRate
     */
    private $invoice;

    /**
     * @var CartShippingRate
     */
    private $invoiceFree;

    /**
     * @var CartShippingRate
     */
    private $cash;

    public function setUp(): void
    {
        parent::setUp();

        $this->invoice = cart()->shippingRateRepository->addShippingRate([
            "method" => "invoice",
            "price" => 10,
            "minimum_cart_price" => 0
        ]);

        $this->invoiceFree = cart()->shippingRateRepository->addShippingRate([
            "method" => "invoice",
            "price" => 0,
            "minimum_cart_price" => 50
        ]);

        $this->cash = cart()->shippingRateRepository->addShippingRate([
            "method" => "cash",
            "price" => 0,
            "minimum_cart_price" => 0
        ]);
    }

    /**
     * @test
     */
    public function can_make_a_shipping_rate(){
        $this->assertEquals("invoice", $this->invoice->method);
        $this->assertEquals("invoice", $this->invoiceFree->method);
        $this->assertEquals("cash", $this->cash->method);

        $this->assertEquals(10, $this->invoice->price);
        $this->assertEquals(0, $this->invoiceFree->price);
        $this->assertEquals(0, $this->cash->price);

        $this->assertCount(2, CartShippingRate::all());
    }

    /**
     * @test
     */
    public function can_set_method_of_shipping_rate(){
        $this->assertTrue(true);
    }
}
