<?php


namespace juniorE\ShoppingCart\Tests\Feature;

use juniorE\ShoppingCart\Tests\TestCase;

class ConfigTest extends TestCase
{
    /**
     * @test
     */
    public function config_test()
    {
        $this->assertEquals("hello world!", config("shoppingcart.test"));
    }
}
