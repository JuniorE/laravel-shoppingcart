<?php


use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
