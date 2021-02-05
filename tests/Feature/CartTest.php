<?php


use Illuminate\Foundation\Testing\RefreshDatabase;
use juniorE\ShoppingCart\Cart;
use juniorE\ShoppingCart\Data\Interfaces\CartDatabase;
use juniorE\ShoppingCart\Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Set up tests
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function can_get_cart()
    {
        $this->assertInstanceOf(Cart::class, cart());
    }

    /**
     * @test
     */
    public function can_add_product_to_cart()
    {
        $this->assertCount(0, cart()->items());
        cart()->addProduct([
            "plu" => 5
        ]);
        $this->assertCount(1, cart()->items());
        $this->assertCount(1, app(CartDatabase::class)
            ->getCartItems(cart()->id));
    }

    /**
     * @test
     */
    public function can_remove_product_from_cart()
    {
        $this->assertCount(0, cart()->items());
        $product = cart()->addProduct([
            "plu" => 5
        ]);
        $this->assertCount(1, cart()->items());
        cart()->removeItem($product);
        $this->assertCount(0, cart()->items());
    }

    /**
     * @test
     */
    public function can_get_product()
    {
        $product = cart()->addProduct([
            "plu" => 5
        ]);

        $dbProduct = app(CartDatabase::class)
            ->getCartItem($product->id);

        $this->assertEquals($product->plu, $dbProduct->plu);
        $this->assertEquals($product->id, $dbProduct->id);
        $this->assertEquals($product->cart_id, $dbProduct->cart_id);
    }

    /**
     * @test
     */
    public function can_set_checkout_method()
    {
        $this->assertEquals(null, cart()->getCart()->checkout_method);
        cart()->setCheckoutMethod("invoice");
        $this->assertEquals("invoice", cart()->getCart()->checkout_method);
    }

    /**
     * @test
     */
    public function can_set_conversion_time()
    {
        cart()->getCart()->update(["created_at" => now()->addMinutes(-15)]);
        $this->assertEquals(null, cart()->getCart()->conversion_time);
        cart()->setCheckoutMethod("invoice");
        $this->assertEquals(15, cart()->getCart()->conversion_time);
    }

    public function can_destroy_cart()
    {
        cart()->addProduct([
            "plu" => 5
        ]);

        $this->assertCount(1, cart()->items());

        $id = cart()->id;
        $identifier = cart()->identifier;

        cart()->destroy();

        $this->assertCount(0, cart()->items());
        $this->assertNotSame($id, cart()->id);
        $this->assertNotSame($identifier, cart()->identifier);
    }
}
