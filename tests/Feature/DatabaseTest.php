<?php


use Illuminate\Foundation\Testing\RefreshDatabase;
use juniorE\ShoppingCart\Models\Cart;
use juniorE\ShoppingCart\Tests\TestCase;

class DatabaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_cart_can_be_saved()
    {
        $this->assertCount(0, Cart::all());

        Cart::create([
            "customer_id" => 1,
        ]);

        $this->assertCount(1, Cart::all());
    }
}
