<?php


namespace juniorE\ShoppingCart;


use juniorE\ShoppingCart\Data\Interfaces\CartShippingRatesDatabase;
use juniorE\ShoppingCart\Models\CartShippingRate;

class CartShippingRatesRepository implements Contracts\CartShippingRatesRepository
{

    public function addShippingRate(array $data): CartShippingRate
    {
        return app(CartShippingRatesDatabase::class)->addShippingRate($data);
    }

    public function setMethod(CartShippingRate $rate, string $method): void
    {
        app(CartShippingRatesDatabase::class)->setMethod($rate, $method);
    }

    public function setMethodDescription(CartShippingRate $rate, string $description): void
    {
        // TODO: Implement setMethodDescription() method.
    }

    public function setPrice(CartShippingRate $rate, float $price): void
    {
        // TODO: Implement setPrice() method.
    }

    public function setMinimumCartPrice(CartShippingRate $rate, float $price): void
    {
        // TODO: Implement setMinimumCartPrice() method.
    }
}
