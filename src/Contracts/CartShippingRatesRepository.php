<?php


namespace juniorE\ShoppingCart\Contracts;


use juniorE\ShoppingCart\Models\CartShippingRate;

interface CartShippingRatesRepository
{
    public function addShippingRate(array $data): CartShippingRate;

    public function setMethod(CartShippingRate $rate, string $method): void;

    public function setMethodDescription(CartShippingRate $rate, string $description): void;

    public function setPrice(CartShippingRate $rate, float $price): void;

    public function setMinimumCartPrice(CartShippingRate $rate, float $price): void;
}