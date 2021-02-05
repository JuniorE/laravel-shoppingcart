<?php


namespace juniorE\ShoppingCart;


use Illuminate\Support\Collection;
use juniorE\ShoppingCart\Models\CartCoupon;
use juniorE\ShoppingCart\Models\CartItem;

class Cart extends BaseCart
{
    public function addProduct(array $product): CartItem
    {
        $cartItem = CartItem::create(
            collect($product)
                ->merge(["cart_id" => $this->id])
                ->toArray()
        );

        $this->cartItems->push($cartItem);
        return $cartItem;
    }

    public function removeItem(CartItem $item): void
    {
        // TODO: Implement removeItem() method.
    }

    public function items(): Collection
    {
        return $this->cartItems;
    }

    public function addCoupon(CartCoupon $coupon): void
    {
        // TODO: Implement addCoupon() method.
    }

    public function checkoutMethod(string $checkoutMethod): void
    {
        // TODO: Implement checkoutMethod() method.
    }
}
