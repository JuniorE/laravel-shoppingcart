<?php


namespace juniorE\ShoppingCart\Data\Interfaces;

use \juniorE\ShoppingCart\Models\Cart;
use juniorE\ShoppingCart\Models\CartItem;

interface CartDatabase
{
    public function createCart(string $identifier): Cart;

    public function getCart(string $identifier): Cart;

    public function createCartItem(array $product): CartItem;

    public function getCartItem(int $id): CartItem;

    public function removeCartItem(CartItem $item): void;
}
