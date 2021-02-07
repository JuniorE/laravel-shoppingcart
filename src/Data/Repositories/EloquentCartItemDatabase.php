<?php


namespace juniorE\ShoppingCart\Data\Repositories;


use juniorE\ShoppingCart\Data\Interfaces\CartItemDatabase;
use juniorE\ShoppingCart\Models\CartItem;

class EloquentCartItemDatabase implements CartItemDatabase
{
    public function setParentCartItem(CartItem $item, int $parentId): void
    {
        $item->update([
            "parent_id" => $parentId
        ]);
    }

    public function setTaxPercent(float $percent): void
    {
        // TODO: Implement setTaxPercent() method.
    }

    public function setCouponCode(string $code): void
    {
        // TODO: Implement setCouponCode() method.
    }

    public function setPrice(float $price): void
    {
        // TODO: Implement setPrice() method.
    }

    public function setWeight(float $weight): void
    {
        // TODO: Implement setWeight() method.
    }

    public function setPLU(string $plu): void
    {
        // TODO: Implement setPLU() method.
    }

    public function setAdditionalData(array $data): void
    {
        // TODO: Implement setAdditionalData() method.
    }
}
