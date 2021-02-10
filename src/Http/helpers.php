<?php

use juniorE\ShoppingCart\Cart;

if (! function_exists('cart')) {
    function cart(string $identifier=null)
    {
        return app()->make(Cart::class, [
            "identifier" => $identifier
        ]);
    }
}
