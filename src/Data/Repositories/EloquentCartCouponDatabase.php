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
        if ($coupon->ends_till && $start > $coupon->ends_till) {
            return;
        }

        $coupon->update([
            "starts_from" => $start
        ]);
    }

    public function setEnd(CartCoupon $coupon, Carbon $end): void
    {
        if ($coupon->starts_from && $end < $coupon->starts_from) {
            return;
        }

        $coupon->update([
            "ends_till" => $end
        ]);
    }

    public function setUsagePerCustomer(CartCoupon $coupon, int $limit): void
    {
        $coupon->update([
            "usage_per_customer" => $limit
        ]);
    }

    public function setUsagePerCoupon(CartCoupon $coupon, int $limit): void
    {
        $coupon->update([
            "uses_per_coupon" => $limit
        ]);
    }

    public function increaseUsedCounter(CartCoupon $coupon, int $amount = 1): void
    {
        if ($amount < 0)
            return;


        $count = $coupon->times_used + $amount;
        if ($count > $coupon->uses_per_coupon) {
            return;
        }

        $coupon->update([
            "times_used" => $count
        ]);
    }

    public function setConditional(CartCoupon $coupon, bool $conditional): void
    {
        $coupon->update([
            "conditional" => $conditional
        ]);
    }

    public function setConditions(CartCoupon $coupon, array $conditions): void
    {
        $coupon->update([
            "conditions" => collect($coupon->conditions)
                ->merge($conditions)
        ]);
    }

    public function setEndsOtherCoupons(CartCoupon $coupon, bool $endsOtherCoupons): void
    {
        $coupon->update([
            "ends_other_coupons" => $endsOtherCoupons
        ]);
    }

    public function setDiscountAmount(CartCoupon $coupon, float $amount): void
    {
        $coupon->update([
            "discount_amount" => $amount
        ]);
    }

    public function setDiscountPercent(CartCoupon $coupon, float $percent): void
    {
        $coupon->update([
            "discount_percent" => $percent
        ]);
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
