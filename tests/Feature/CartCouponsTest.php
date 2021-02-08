<?php


use Illuminate\Foundation\Testing\RefreshDatabase;
use juniorE\ShoppingCart\Enums\CouponTypes;
use juniorE\ShoppingCart\Tests\TestCase;

use \juniorE\ShoppingCart\Models\CartCoupon;

class CartCouponsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_make_coupon(){
        cart()->couponsRepository->addCoupon([
            "name" => "WELCOME10",
            "discount_percent" => 0.10
        ]);

        cart()->couponsRepository->addCoupon([
            "name" => "GOEDE BUREN",
            "discount_percent" => 1
        ]);

        $this->assertCount(2, CartCoupon::all());
        $this->assertNull(CartCoupon::firstWhere('name', '=', 'doesnt exist'));
        $this->assertNotNull(CartCoupon::firstWhere('name', '=', 'WELCOME10'));
        $this->assertNotNull(CartCoupon::firstWhere('name', '=', 'GOEDE BUREN'));
    }
    
    /**
     * @test
     */
    public function can_update_name(){
        $coupon = cart()->couponsRepository->addCoupon([
            "name" => "WELCOME10",
            "discount_percent" => 1
        ]);

        $this->assertEquals("WELCOME10", $coupon->name);

        cart()->couponsRepository->setName($coupon, "GOEDE BUREN");

        $this->assertEquals("GOEDE BUREN", $coupon->name);
    }

    /**
     * @test
     */
    public function can_update_description(){
        $coupon = cart()->couponsRepository->addCoupon([
            "name" => "GOEDE BUREN",
            "description" => "Omdat we goeie buren zijn",
            "discount_percent" => 1
        ]);

        $this->assertEquals("Omdat we goeie buren zijn", $coupon->description);

        cart()->couponsRepository->setDescription($coupon, "GOEDE BUREN");

        $this->assertEquals("GOEDE BUREN", $coupon->description);
    }

    /**
     * @test
     */
    public function can_update_status(){
        $coupon = cart()->couponsRepository->addCoupon([
            "name" => "GOEDE BUREN",
            "status" => false,
            "discount_percent" => 1
        ]);

        $this->assertEquals(false, $coupon->status);

        cart()->couponsRepository->setStatus($coupon, true);

        $this->assertEquals(true, $coupon->status);
    }

    /**
     * @test
     */
    public function can_update_type(){
        $coupon = cart()->couponsRepository->addCoupon([
            "name" => "GOEDE BUREN",
            "discount_percent" => 1,
            "coupon_type" => CouponTypes::PERCENT
        ]);

        $this->assertEquals(CouponTypes::PERCENT, $coupon->coupon_type);

        cart()->couponsRepository->setCouponType($coupon, CouponTypes::STEP);

        $this->assertEquals(CouponTypes::STEP, $coupon->coupon_type);
    }

    /**
     * @test
     */
    public function can_set_start_and_end(){
        $coupon = cart()->couponsRepository->addCoupon([
            "name" => "GOEDE BUREN"
        ]);

        $this->assertNull($coupon->starts_from);
        $this->assertNull($coupon->ends_till);

        $start = now();
        $end = now()->addMonth();

        cart()->couponsRepository->setStart($coupon, $start);
        cart()->couponsRepository->setEnd($coupon, $end);

        $this->assertEquals($start->format('Y-m-d'), $coupon->starts_from->format('Y-m-d'));
        $this->assertEquals($end->format('Y-m-d'), $coupon->ends_till->format('Y-m-d'));

        cart()->couponsRepository->setEnd($coupon, $end->clone()->subMonths(2));

        $this->assertEquals($end->format('Y-m-d'), $coupon->ends_till->format('Y-m-d'));
    }

    /**
     * @test
     */
    public function can_update_usage_per_customer(){
        $coupon = cart()->couponsRepository->addCoupon([
            "name" => "GOEDE BUREN",
            "discount_percent" => 1,
            "usage_per_customer" => 10
        ]);

        $this->assertEquals(10, $coupon->usage_per_customer);

        cart()->couponsRepository->setUsagePerCustomer($coupon, 15);

        $this->assertEquals(15, $coupon->usage_per_customer);
    }

    /**
     * @test
     */
    public function can_update_usage_per_coupon(){
        $coupon = cart()->couponsRepository->addCoupon([
            "name" => "GOEDE BUREN",
            "discount_percent" => 1,
            "uses_per_coupon" => 10
        ]);

        $this->assertEquals(10, $coupon->uses_per_coupon);

        cart()->couponsRepository->setUsagePerCoupon($coupon, 15);

        $this->assertEquals(15, $coupon->uses_per_coupon);
    }

    /**
     * @test
     */
    public function can_increase_used_counter(){
        $coupon = cart()->couponsRepository->addCoupon([
            "name" => "GOEDE BUREN",
            "discount_percent" => 1,
            "uses_per_coupon" => 10
        ]);

        $this->assertEquals(0, $coupon->times_used);

        cart()->couponsRepository->increaseUsedCounter($coupon);

        $this->assertEquals(1, $coupon->times_used);

        cart()->couponsRepository->increaseUsedCounter($coupon, 1);

        $this->assertEquals(2, $coupon->times_used);

        cart()->couponsRepository->increaseUsedCounter($coupon, 6);

        $this->assertEquals(8, $coupon->times_used);

        cart()->couponsRepository->increaseUsedCounter($coupon, 2);

        $this->assertEquals(10, $coupon->times_used);

        cart()->couponsRepository->increaseUsedCounter($coupon);

        $this->assertEquals(10, $coupon->times_used);
    }

    /**
     * @test
     */
    public function can_update_conditional_and_conditions(){
        $coupon = cart()->couponsRepository->addCoupon([
            "name" => "GOEDE BUREN",
            "discount_percent" => 1,
            "uses_per_coupon" => 10,
            "conditional" => false
        ]);

        $this->assertFalse($coupon->conditional);

        cart()->couponsRepository->setConditional($coupon, true);

        $this->assertTrue($coupon->conditional);

        cart()->couponsRepository->setConditions($coupon, [
            "minimum_price" => 50,
            "contains_products" => [5, 7]
        ]);

        $this->assertEquals(50, $coupon->conditions["minimum_price"]);
        $this->assertContains(5, $coupon->conditions["contains_products"]);
        $this->assertContains(7, $coupon->conditions["contains_products"]);

        cart()->couponsRepository->setConditions($coupon, [
            "minimum_price" => 25
        ]);

        $this->assertEquals(25, $coupon->conditions["minimum_price"]);
        $this->assertContains(5, $coupon->conditions["contains_products"]);
        $this->assertContains(7, $coupon->conditions["contains_products"]);
    }

    /**
     * @test
     */
    public function can_update_ends_other_coupons(){
        $coupon = cart()->couponsRepository->addCoupon([
            "name" => "GOEDE BUREN",
            "discount_percent" => 1,
            "ends_other_coupons" => false
        ]);

        $this->assertFalse($coupon->ends_other_coupons);

        cart()->couponsRepository->setEndsOtherCoupons($coupon, true);

        $this->assertTrue($coupon->ends_other_coupons);
    }

}
