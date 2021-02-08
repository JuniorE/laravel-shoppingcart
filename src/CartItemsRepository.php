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
        $this->getDatabase()->setTaxPercent($item, $percent);
    }

    public function setCouponCode(CartItem $item, string $code): void
    {
        $item->update([
            "coupon_code" => $code
        ]);
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
        $this->getDatabase()->setPLU($item, $plu);
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
