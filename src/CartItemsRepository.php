<?php


namespace juniorE\ShoppingCart;


use juniorE\ShoppingCart\Data\Interfaces\CartItemDatabase;
use juniorE\ShoppingCart\Models\CartItem;

class CartItemsRepository implements Contracts\CartItemsRepository
{
    public function setParentCartItem(CartItem $item, int $parentId): void
    {
        $this->getDatabase()->setParentCartItem($item, $parentId);
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
        $this->getDatabase()->setPrice($item, $price);
    }

    public function setWeight(CartItem $item, float $weight): void
    {
        $this->getDatabase()->setWeight($item, $weight);
    }

    public function setPLU(CartItem $item, string $plu): void
    {
        // TODO: Implement setPLU() method.
    }

    public function setAdditionalData(CartItem $item, array $data): void
    {
        $this->getDatabase()->setAdditionalData($item, $data);
    }

    private function getDatabase()
    {
        return app(CartItemDatabase::class);
    }
}
