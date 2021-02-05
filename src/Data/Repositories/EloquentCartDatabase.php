<?php


namespace juniorE\ShoppingCart\Data\Repositories;


use Illuminate\Support\Collection;
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
        return CartItem::find($id);
    }

    public function getCartItems(int $cartIdentifier): Collection
    {
        return CartItem::where('cart_id', cart()->id)->get();
    }

    public function removeCartItem(CartItem $item): void
    {
        $item->delete();
    }

    public function setCheckoutMethod(string $method): void
    {
        cart()->getCart()->update([
            "checkout_method" => $method
        ]);
    }

    public function setConversionTime(int $minutes): void
    {
        cart()->getCart()->update([
            "conversion_time" => $minutes
        ]);
    }

    public function clear(bool $hard=false): void
    {
        if ($hard) {
            cart()->getCart()->forceDelete();
        } else {
            cart()->getCart()->delete();
        }
    }
}
