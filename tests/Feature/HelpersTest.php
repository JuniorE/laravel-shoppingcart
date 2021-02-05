<?php


use juniorE\ShoppingCart\Cart;
use juniorE\ShoppingCart\Tests\TestCase;

class HelpersTest extends TestCase
{
    /**
     * @test
     */
    public function can_access_helpers()
    {
        $this->assertInstanceOf(Cart::class, cart());
    }
}
