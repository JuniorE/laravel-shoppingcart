<?php


namespace juniorE\ShoppingCart\Contracts;


use Illuminate\Support\Collection;
use juniorE\ShoppingCart\Models\CartCoupon;
use juniorE\ShoppingCart\Models\CartItem;

interface Cart
{
    /**
     * Add a product to the cart
     * 
     * @param array $product
     * @return CartItem
     */
    public function addProduct(array $product): CartItem;

    /**
     * Remove a cart item from the cart
     *
     * @param CartItem $item
     * @return void
     */
    public function removeItem(CartItem $item): void;

    /**
     * Add a coupon to the cart
     *
     * @param CartCoupon $coupon
     */
    public function addCoupon(CartCoupon $coupon): void;


    /**
     * Set the checkoutMethod, this also marks the cart as 'closed' and
     * calculates the conversion time.
     *
     * @param string $checkoutMethod
     * @return mixed
     */
    public function checkoutMethod(string $checkoutMethod): void;

    /**
     * Get Items from cart
     * 
     * @return Collection|CartItem[]
     */
    public function items(): Collection;
}
