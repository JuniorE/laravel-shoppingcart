<?php


namespace juniorE\ShoppingCart;


use Illuminate\Support\Collection;
use juniorE\ShoppingCart\Models\CartCoupon;
use juniorE\ShoppingCart\Models\CartItem;

class Cart implements Contracts\Cart
{

    public function addProduct(array $product): CartItem
    {
        // TODO: Implement addProduct() method.
        return new CartItem();
    }

    public function removeItem(CartItem $item): void
    {
        // TODO: Implement removeItem() method.
    }

    public function items(): Collection
    {
        // TODO: Implement items() method.
        return collect();
    }

    public function addCoupon(CartCoupon $coupon): void
    {
        // TODO: Implement addCoupon() method.
    }
}
