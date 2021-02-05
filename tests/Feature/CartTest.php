<?php


use Illuminate\Foundation\Testing\RefreshDatabase;
use juniorE\ShoppingCart\Cart;
use juniorE\ShoppingCart\Models\CartItem;
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
        $this->assertCount(1, CartItem::where('cart_id', cart()->identifier)->get());
    }
}
