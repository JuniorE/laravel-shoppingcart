<?php


namespace juniorE\ShoppingCart;


use Illuminate\Support\Collection;
use juniorE\ShoppingCart\Data\Interfaces\CartDatabase;
use juniorE\ShoppingCart\Data\Interfaces\VisitsHistoryDatabase;
use juniorE\ShoppingCart\Models\CartCoupon;
use juniorE\ShoppingCart\Models\CartItem;
use juniorE\ShoppingCart\Models\CartShippingRate;

class Cart extends BaseCart
{
    public function addProduct(array $product, bool $forceNewLine=false): CartItem
    {
        $product = collect($product)
            ->merge(["cart_id" => $this->id])
            ->toArray();

        if ($forceNewLine) {
            return $this->createCartItem($product);
        }

        return $this->updateOrCreateCartItem($product);
    }

    public function removeItem(CartItem $item): void
    {
        $this->cartItems->filter(function ($cartItem) use ($item) {
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
        app(CartDatabase::class)->addCoupon($coupon);
    }

    public function setCheckoutMethod(string $checkoutMethod): void
    {
        $database = app(CartDatabase::class);
        $database->setCheckoutMethod($checkoutMethod);
        $database->setConversionTime(now()->diffInMinutes($this->getCart()->created_at));
    }

    public function setShippingMethod(string $method): void
    {
        app(CartDatabase::class)->setShippingMethod($method);
    }

    public function setAdditionalData(array $data)
    {
        app(CartDatabase::class)->setAdditionalData($data);
    }

    public function getCart(): Models\Cart
    {
        return app(CartDatabase::class)->getCart($this->identifier);
    }

    public function history()
    {
        return $this->getCart()->history;
    }

    public function markVisited(string $plu): void
    {
        app(VisitsHistoryDatabase::class)->markVisited($plu);
    }

    public function updateIdentifier(string $identifier): void
    {
        $this->getCart()->update([
            "identifier" => $identifier
        ]);

        $this->identifier = $identifier;
        session()->put(self::SESSION_CART_IDENTIFIER, $identifier);
    }

    public function getShippingRate(): CartShippingRate
    {
        $rates = $this->shippingRateRepository->shippingRatesForMethod($this->getCart()->shipping_method)
            ->where("minimum_cart_price", "<=", $this->getCart()->grand_total)
            ->sortBy('minimum_cart_price');

        return $rates->last();
    }

    public function contains(array $plus): bool
    {
        $items = cart()->items()->map->only("plu")->flatten();
        $success = true;
        foreach ($plus as $plu) {
            if (!$items->contains($plu)) {
                $success = false;
                continue;
            } else {
                $success = true;
            }
        }
        return $success;
    }

    private function updateOrCreateCartItem(array $product): CartItem
    {
        $database = app(CartDatabase::class);

        $hash = CartItem::getHash($product);

        $existingCartItem = $database->getCartItemByHash($hash);

        if ($existingCartItem) {
            return $this->updateQuantity($existingCartItem, $existingCartItem->quantity + ($product["quantity"] ?? 0));
        } else {
            return $this->createCartItem($product);
        }
    }

    private function updateQuantity(CartItem $item, $quantity): CartItem
    {
        $this->itemsRepository->setQuantity($item, $quantity);

        $this->cartItems = $this->getCart()->items;

        return $item;
    }

    private function createCartItem(array $product): CartItem
    {
        $database = app(CartDatabase::class);

        $cartItem = $database->createCartItem($product);
        $this->cartItems->push($cartItem);

        return $cartItem;
    }

    /**
     * @return Collection|CartItem[]
     */
    public function itemsTree(): Collection
    {
        return app(CartDatabase::class)->getCartItemsTree();
    }
}
