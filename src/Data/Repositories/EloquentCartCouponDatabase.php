<?php


namespace juniorE\ShoppingCart\Data\Repositories;


use Carbon\Carbon;
use juniorE\ShoppingCart\Data\Interfaces\CartCouponDatabase;

class EloquentCartCouponDatabase implements CartCouponDatabase
{
    public function addCoupon(array $data): void
    {
        // TODO: Implement addCoupon() method.
    }

    public function setName(string $name): void
    {
        // TODO: Implement setName() method.
    }

    public function setDescription(string $description): void
    {
        // TODO: Implement setDescription() method.
    }

    public function setStatus(bool $status): void
    {
        // TODO: Implement setStatus() method.
    }

    public function setCouponType(int $type): void
    {
        // TODO: Implement setCouponType() method.
    }

    public function setStart(Carbon $start): void
    {
        // TODO: Implement setStart() method.
    }

    public function setEnd(Carbon $end): void
    {
        // TODO: Implement setEnd() method.
    }

    public function setUsagePerCustomer(int $limit): void
    {
        // TODO: Implement setUsagePerCustomer() method.
    }

    public function setUsagePerCoupon(int $limit): void
    {
        // TODO: Implement setUsagePerCoupon() method.
    }

    public function increaseUsedCounter(int $amount = 1): void
    {
        // TODO: Implement increaseUsedCounter() method.
    }

    public function setConditional(bool $conditional): void
    {
        // TODO: Implement setConditional() method.
    }

    public function setConditions(array $conditions): void
    {
        // TODO: Implement setConditions() method.
    }

    public function setEndsOtherCoupons(bool $endsOtherCoupons): void
    {
        // TODO: Implement setEndsOtherCoupons() method.
    }

    public function setDiscountAmount(int $amount): void
    {
        // TODO: Implement setDiscountAmount() method.
    }

    public function setDiscountPercent(float $percent): void
    {
        // TODO: Implement setDiscountPercent() method.
    }

    public function setDiscountQuantity(int $quantity): void
    {
        // TODO: Implement setDiscountQuantity() method.
    }

    public function setDiscountStep(int $step): void
    {
        // TODO: Implement setDiscountStep() method.
    }

    public function setAppliesToShipping(bool $applies): void
    {
        // TODO: Implement setAppliesToShipping() method.
    }

    public function setFreeShipping(bool $freeShipping): void
    {
        // TODO: Implement setFreeShipping() method.
    }
}
