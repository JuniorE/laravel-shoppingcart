<?php


namespace juniorE\ShoppingCart\Tests\Feature;

use juniorE\ShoppingCart\Tests\TestCase;

class ConfigTest extends TestCase
{
    /**
     * @test
     */
    public function configTest()
    {
        $this->assertEquals("hello world!", config("shoppingcart.test"));
    }
}
