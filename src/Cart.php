<?php


namespace juniorE\ShoppingCart;


use Illuminate\Support\Collection;
use juniorE\ShoppingCart\Data\Interfaces\CartDatabase;
use juniorE\ShoppingCart\Models\CartCoupon;
use juniorE\ShoppingCart\Models\CartItem;

class Cart extends BaseCart
{
    public function addProduct(array $product): CartItem
    {
        $cartItem = app(CartDatabase::class)->createCartItem(
            collect($product)
                ->merge(["cart_id" => $this->id])
                ->toArray()
        );

        $this->cartItems->push($cartItem);
        return $cartItem;
    }

    public function removeItem(CartItem $item): void
    {
        $this->cartItems->filter(function($cartItem) use ($item) {
            return $cartItem->id !== $item->id;
        });

        app(CartDatabase::class)->removeCartItem($item);
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
