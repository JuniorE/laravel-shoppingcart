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

    public function setTaxPercent(CartItem $item, float $percent): void
    {
        // TODO: Implement setTaxPercent() method.
    }

    public function setCouponCode(CartItem $item, string $code): void
    {
        // TODO: Implement setCouponCode() method.
    }

    public function setPrice(CartItem $item, float $price): void
    {
        // TODO: Implement setPrice() method.
    }

    public function setWeight(CartItem $item, float $weight): void
    {
        // TODO: Implement setWeight() method.
    }

    public function setPLU(CartItem $item, string $plu): void
    {
        // TODO: Implement setPLU() method.
    }

    public function setAdditionalData(CartItem $item, array $data): void
    {
        $item->update([
            'additional' => collect($item->additional)
                ->merge($data)
        ]);
    }
}
