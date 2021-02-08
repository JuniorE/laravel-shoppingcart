<?php


namespace juniorE\ShoppingCart\Data\Repositories;


use juniorE\ShoppingCart\Data\Interfaces\CartShippingRatesDatabase;
use juniorE\ShoppingCart\Models\CartShippingRate;

class EloquentCartShippingRatesDatabase implements CartShippingRatesDatabase
{
    public function addShippingRate(array $data): CartShippingRate
    {
        return CartShippingRate::create($data);
    }

    public function setMethod(CartShippingRate $rate, string $method): void
    {
        // TODO: Implement setMethod() method.
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
