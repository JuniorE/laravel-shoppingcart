<?php


namespace juniorE\ShoppingCart\Data\Interfaces;


use Carbon\Carbon;

interface CartCouponDatabase
{
    public function addCoupon(array $data): void;

    public function setName(string $name): void;

    public function setDescription(string $description): void;

    public function setStatus(bool $status): void;

    public function setCouponType(int $type): void;

    public function setStart(Carbon $start): void;

    public function setEnd(Carbon $end): void;

    public function setUsagePerCustomer(int $limit): void;

    public function setUsagePerCoupon(int $limit): void;

    public function increaseUsedCounter(int $amount=1): void;

    public function setConditional(bool $conditional): void;

    public function setConditions(array $conditions): void;

    public function setEndsOtherCoupons(bool $endsOtherCoupons): void;

    public function setDiscountAmount(int $amount): void;

    public function setDiscountPercent(float $percent): void;

    public function setDiscountQuantity(int $quantity): void;

    public function setDiscountStep(int $step): void;

    public function setAppliesToShipping(bool $applies): void;

    public function setFreeShipping(bool $freeShipping): void;
}
