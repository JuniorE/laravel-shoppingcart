<?php


use Illuminate\Foundation\Testing\RefreshDatabase;
use juniorE\ShoppingCart\Cart;
use juniorE\ShoppingCart\Data\Interfaces\CartDatabase;
use juniorE\ShoppingCart\Tests\TestCase;
use juniorE\ShoppingCart\Models as Models;

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

    /**
     * @test
     */
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

    /**
     * @test
     */
    public function can_cleanup_idle_carts()
    {
        DB::table("carts")->insert([
            ["identifier" => 1, "updated_at" => now()->subDays(1)],
            ["identifier" => 2, "updated_at" => now()->subDays(10)],
            ["identifier" => 3, "updated_at" => now()->subDays(11)],
            ["identifier" => 4, "updated_at" => now()->subDays(13)],
            ["identifier" => 5, "updated_at" => now()->subDays(14)],
            ["identifier" => 6, "updated_at" => now()->subDays(17)],
            ["identifier" => 7, "updated_at" => now()->subDays(24)],
            ["identifier" => 8, "updated_at" => now()->subDays(30)],
            ["identifier" => 9, "updated_at" => now()->subDays(31)],
            ["identifier" => 10, "updated_at" => now()->subDays(32)],
            ["identifier" => 11, "updated_at" => now()->subDays(34)],
            ["identifier" => 12, "updated_at" => now()->subDays(42)],
            ["identifier" => 13, "updated_at" => now()->subDays(42)],
            ["identifier" => 14, "updated_at" => now()->subDays(42)],
            ["identifier" => 15, "updated_at" => now()->subDays(42)],
        ]);

        $this->assertCount(15, Models\Cart::all());

        $this->assertFalse(Models\Cart::all()->every(function(Models\Cart $cart) {
            return now()->diffInDays($cart->updated_at) < 30;
        }));

        Models\Cart::clean();

        $this->assertCount(7, Models\Cart::all());

        $this->assertTrue(Models\Cart::all()->every(function(Models\Cart $cart) {
            return now()->diffInDays($cart->updated_at) < 30;
        }));
    }
}
