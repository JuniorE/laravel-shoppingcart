<?php


namespace juniorE\ShoppingCart\Data\Repositories;


use juniorE\ShoppingCart\Data\Interfaces\CartDatabase;
use juniorE\ShoppingCart\Data\Interfaces\CartItemDatabase;
use juniorE\ShoppingCart\Models\CartItem;

class EloquentCartItemDatabase implements CartItemDatabase
{
    public function emptyCart(int $id): void
    {
        CartItem::where('cart_id', $id)->delete();
        app(CartDatabase::class)->updateTotal($id);
    }

    public function setQuantity(CartItem $item, int $quantity): void
    {
        $item->update([
            'quantity' => $quantity
        ]);
    }

    public function setParentCartItem(CartItem $item, int $parentId): void
    {
        $item->update([
            "parent_id" => $parentId
        ]);
    }

    public function setTaxPercent(CartItem $item, float $percent): void
    {
        $item->update([
            "tax_percent" => $percent,
            "tax_amount" => $item->price * $percent
        ]);
    }

    public function setCouponCode(CartItem $item, string $code): void
    {
        $item->update([
            "coupon_code" => $code
        ]);

        $this->updatePrices($item);
    }

    public function setPrice(CartItem $item, float $price): void
    {
        $item->update([
            "price" => $price,
            "tax_amount" => $price * $item->tax_percent
        ]);
    }

    public function setWeight(CartItem $item, float $weight): void
    {
        $item->update([
            "weight" => $weight
        ]);
    }

    public function setPLU(CartItem $item, string $plu): void
    {
        if (!$plu) {
            return;
        }

        $item->update([
            "plu" => $plu
        ]);
    }

    public function setAdditionalData(CartItem $item, array $data): void
    {
        $item->update([
            'additional' => collect($item->additional)
                ->merge($data)
        ]);
    }

    private function updatePrices(CartItem $item)
    {
        if (!$item->coupon) {
            return;
        }

        $discount = $item->coupon->discount($item->price * $item->quantity, $item->quantity, $item->price);
        $item->update([
            "discount" => $discount
        ]);

        app(CartDatabase::class)->updateTotal();
    }
}
