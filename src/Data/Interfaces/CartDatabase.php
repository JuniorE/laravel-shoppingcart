<?php


namespace juniorE\ShoppingCart\Data\Interfaces;

use Illuminate\Support\Collection;
use \juniorE\ShoppingCart\Models\Cart;
use juniorE\ShoppingCart\Models\CartItem;

interface CartDatabase
{
    public function createCart(string $identifier): Cart;

    public function getCart(string $identifier): Cart;

    public function createCartItem(array $product): CartItem;

    public function getCartItem(int $id): CartItem;

    public function getCartItems(int $cartIdentifier): Collection;

    public function removeCartItem(CartItem $item): void;

    public function setCheckoutMethod(string $method): void;

    public function setConversionTime(int $minutes): void;

    public function clear(bool $hard=false): void;
}
