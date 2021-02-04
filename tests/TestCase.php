<?php


namespace juniorE\ShoppingCart\Tests;


use juniorE\ShoppingCart\ShoppingCartBaseServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ShoppingCartBaseServiceProvider::class,

        ];
    }
}
