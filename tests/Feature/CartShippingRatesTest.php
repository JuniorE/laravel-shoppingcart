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

        $this->assertCount(3, CartShippingRate::all());
    }

    /**
     * @test
     */
    public function can_set_method_of_shipping_rate(){
        $mistakeInvoice = cart()->shippingRateRepository->addShippingRate([
            "method" => "cash",
            "price" => 0,
            "minimum_cart_price" => 0
        ]);

        $this->assertEquals("cash", $mistakeInvoice->method);

        cart()->shippingRateRepository->setMethod($mistakeInvoice, "invoice");

        $this->assertEquals("invoice", $mistakeInvoice->method);
    }
    
    /**
     * @test
     */
    public function can_set_method_description(){
        $this->assertNull($this->invoice->method_description);

        cart()->shippingRateRepository->setMethodDescription($this->invoice, "lorem ipsum");

        $this->assertEquals("lorem ipsum", $this->invoice->method_description);
    }

    /**
     * @test
     */
    public function can_set_price_of_shipping_rate(){
        $this->assertEquals(10, $this->invoice->price);

        cart()->shippingRateRepository->setPrice($this->invoice, 20);

        $this->assertEquals(20, $this->invoice->price);
        $this->assertEquals(0, $this->invoiceFree->price);
    }
}
