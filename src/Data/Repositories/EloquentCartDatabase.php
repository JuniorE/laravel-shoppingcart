<?php


namespace juniorE\ShoppingCart\Data\Repositories;


use juniorE\ShoppingCart\Data\Interfaces\CartDatabase;
use juniorE\ShoppingCart\Models\Cart;
use juniorE\ShoppingCart\Models\CartItem;

class EloquentCartDatabase implements CartDatabase
{
    public function createCart(string $identifier): Cart
    {
        return Cart::create([
            "identifier" => $identifier
        ]);
    }

    public function getCart(string $identifier): Cart
    {
        return Cart::where('identifier', $identifier)->first();
    }

    public function createCartItem(array $product): CartItem
    {
        return CartItem::create($product);
    }

    public function getCartItem(int $id): CartItem
    {
        // TODO: Implement getCartItem() method.
    }

    public function removeCartItem(CartItem $item): void
    {
        $item->delete();
    }
}
