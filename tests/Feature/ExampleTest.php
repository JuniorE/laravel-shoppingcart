<?php


namespace juniorE\ShoppingCart\Tests\Feature;

use juniorE\ShoppingCart\Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * @test
     */
    public function configTest()
    {
        $this->assertEquals("hello world!", config("shoppingcart.test"));
    }
}
