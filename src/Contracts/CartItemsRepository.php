<?php


namespace juniorE\ShoppingCart\Contracts;


use juniorE\ShoppingCart\Models\CartItem;

interface CartItemsRepository
{
    /**
     * @param CartItem $item
     */
    public function setParentCartItem(CartItem $item): void;

    /**
     * @param float $percent
     */
    public function setTaxPercent(float $percent): void;

    /**
     * @param string $code
     */
    public function setCouponCode(string $code): void;

    /**
     * @param float $price
     */
    public function setPrice(float $price): void;

    /**
     * @param float $weight
     */
    public function setWeight(float $weight): void;

    /**
     * @param string $plu
     */
    public function setPLU(string $plu): void;

    /**
     * @param array $data
     */
    public function setAdditionalData(array $data): void;
}
