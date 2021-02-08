<?php


namespace juniorE\ShoppingCart;


use juniorE\ShoppingCart\Models\CartShippingRate;

class CartShippingRates implements Contracts\CartShippingRatesRepository
{

    public function addShippingRate(array $data): CartShippingRate
    {
        // TODO: Implement addShippingRate() method.
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
