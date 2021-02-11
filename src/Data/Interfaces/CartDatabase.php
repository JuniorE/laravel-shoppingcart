<?php


namespace juniorE\ShoppingCart\Data\Interfaces;

use Illuminate\Support\Collection;
use \juniorE\ShoppingCart\Models\Cart;
use juniorE\ShoppingCart\Models\CartCoupon;
use juniorE\ShoppingCart\Models\CartItem;

interface CartDatabase
{
    public function createCart(string $identifier): Cart;

    /**
     * @param string $identifier
     * @return Cart|null
     */
    public function getCart(string $identifier);

    public function createCartItem(array $product): CartItem;

    /**
     * @param int $id
     * @return CartItem|null
     */
    public function getCartItem(int $id);

    /**
     * @param int $cartIdentifier
     * @return Collection|CartItem[]
     */
    public function getCartItems(int $cartIdentifier);

    public function removeCartItem(CartItem $item): void;

    public function setCheckoutMethod(string $method): void;

    public function setShippingMethod(string $method): void;

    public function setConversionTime(int $minutes): void;

    public function updateTotal();

    public function setAdditionalData(array $data);

    public function addCoupon(CartCoupon $coupon): void;

    public function clear(bool $hard=false): void;
}
