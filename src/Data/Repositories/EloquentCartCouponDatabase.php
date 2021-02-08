<?php


namespace juniorE\ShoppingCart\Data\Repositories;


use Carbon\Carbon;
use juniorE\ShoppingCart\Data\Interfaces\CartCouponDatabase;
use juniorE\ShoppingCart\Models\CartCoupon;

class EloquentCartCouponDatabase implements CartCouponDatabase
{
    public function addCoupon(array $data): CartCoupon
    {
        return CartCoupon::create($data);
    }

    public function setName(CartCoupon $coupon, string $name): void
    {
        $coupon->update([
            "name" => $name
        ]);
    }

    public function setDescription(CartCoupon $coupon, string $description): void
    {
        $coupon->update([
            "description" => $description
        ]);
    }

    public function setStatus(CartCoupon $coupon, bool $status): void
    {
        $coupon->update([
            "status" => $status
        ]);
    }

    public function setCouponType(CartCoupon $coupon, int $type): void
    {
        $coupon->update([
            "coupon_type" => $type
        ]);
    }

    public function setStart(CartCoupon $coupon, Carbon $start): void
    {
        // TODO: Implement setStart() method.
    }

    public function setEnd(CartCoupon $coupon, Carbon $end): void
    {
        // TODO: Implement setEnd() method.
    }

    public function setUsagePerCustomer(CartCoupon $coupon, int $limit): void
    {
        // TODO: Implement setUsagePerCustomer() method.
    }

    public function setUsagePerCoupon(CartCoupon $coupon, int $limit): void
    {
        // TODO: Implement setUsagePerCoupon() method.
    }

    public function increaseUsedCounter(CartCoupon $coupon, int $amount = 1): void
    {
        // TODO: Implement increaseUsedCounter() method.
    }

    public function setConditional(CartCoupon $coupon, bool $conditional): void
    {
        // TODO: Implement setConditional() method.
    }

    public function setConditions(CartCoupon $coupon, array $conditions): void
    {
        // TODO: Implement setConditions() method.
    }

    public function setEndsOtherCoupons(CartCoupon $coupon, bool $endsOtherCoupons): void
    {
        // TODO: Implement setEndsOtherCoupons() method.
    }

    public function setDiscountAmount(CartCoupon $coupon, int $amount): void
    {
        // TODO: Implement setDiscountAmount() method.
    }

    public function setDiscountPercent(CartCoupon $coupon, float $percent): void
    {
        // TODO: Implement setDiscountPercent() method.
    }

    public function setDiscountQuantity(CartCoupon $coupon, int $quantity): void
    {
        // TODO: Implement setDiscountQuantity() method.
    }

    public function setDiscountStep(CartCoupon $coupon, int $step): void
    {
        // TODO: Implement setDiscountStep() method.
    }

    public function setAppliesToShipping(CartCoupon $coupon, bool $applies): void
    {
        // TODO: Implement setAppliesToShipping() method.
    }

    public function setFreeShipping(CartCoupon $coupon, bool $freeShipping): void
    {
        // TODO: Implement setFreeShipping() method.
    }
}
