<?php


use Illuminate\Foundation\Testing\RefreshDatabase;
use juniorE\ShoppingCart\Cart;
use juniorE\ShoppingCart\Data\Interfaces\CartDatabase;
use juniorE\ShoppingCart\Enums\CouponTypes;
use juniorE\ShoppingCart\Tests\TestCase;
use juniorE\ShoppingCart\Models as Models;

class CartTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Set up tests
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function can_get_cart()
    {
        $this->assertInstanceOf(Cart::class, cart());
    }

    /**
     * @test
     */
    public function can_add_product_to_cart()
    {
        $this->assertCount(0, cart()->items());
        cart()->addProduct([
            "plu" => 5
        ]);
        $this->assertCount(1, cart()->items());
        $this->assertCount(1, app(CartDatabase::class)
            ->getCartItems(cart()->id));
    }

    /**
     * @test
     */
    public function can_remove_product_from_cart()
    {
        $this->assertCount(0, cart()->items());
        $product = cart()->addProduct([
            "plu" => 5
        ]);
        $this->assertCount(1, cart()->items());
        cart()->removeItem($product);
        $this->assertCount(0, cart()->items());
    }

    /**
     * @test
     */
    public function can_get_product()
    {
        $product = cart()->addProduct([
            "plu" => 5
        ]);

        $dbProduct = app(CartDatabase::class)
            ->getCartItem($product->id);

        $this->assertEquals($product->plu, $dbProduct->plu);
        $this->assertEquals($product->id, $dbProduct->id);
        $this->assertEquals($product->cart_id, $dbProduct->cart_id);
    }

    /**
     * @test
     */
    public function can_set_checkout_method()
    {
        $this->assertEquals(null, cart()->getCart()->checkout_method);
        cart()->setCheckoutMethod("invoice");
        $this->assertEquals("invoice", cart()->getCart()->checkout_method);
    }

    /**
     * @test
     */
    public function can_set_conversion_time()
    {
        cart()->getCart()->update(["created_at" => now()->addMinutes(-15)]);
        $this->assertEquals(null, cart()->getCart()->conversion_time);
        cart()->setCheckoutMethod("invoice");
        $this->assertEquals(15, cart()->getCart()->conversion_time);
    }

    /**
     * @test
     */
    public function can_destroy_cart()
    {
        cart()->addProduct([
            "plu" => 5
        ]);

        $this->assertCount(1, cart()->items());

        $id = cart()->id;
        $identifier = cart()->identifier;

        cart()->destroy();

        $this->assertCount(0, cart()->items());
        $this->assertNotSame($id, cart()->id);
        $this->assertNotSame($identifier, cart()->identifier);
    }

    /**
     * @test
     */
    public function can_cleanup_idle_carts()
    {
        DB::table("carts")->insert([
            ["identifier" => 1, "updated_at" => now()->subDays(1)],
            ["identifier" => 2, "updated_at" => now()->subDays(10)],
            ["identifier" => 3, "updated_at" => now()->subDays(11)],
            ["identifier" => 4, "updated_at" => now()->subDays(13)],
            ["identifier" => 5, "updated_at" => now()->subDays(14)],
            ["identifier" => 6, "updated_at" => now()->subDays(17)],
            ["identifier" => 7, "updated_at" => now()->subDays(24)],
            ["identifier" => 8, "updated_at" => now()->subDays(30)],
            ["identifier" => 9, "updated_at" => now()->subDays(31)],
            ["identifier" => 10, "updated_at" => now()->subDays(32)],
            ["identifier" => 11, "updated_at" => now()->subDays(34)],
            ["identifier" => 12, "updated_at" => now()->subDays(42)],
            ["identifier" => 13, "updated_at" => now()->subDays(42)],
            ["identifier" => 14, "updated_at" => now()->subDays(42)],
            ["identifier" => 15, "updated_at" => now()->subDays(42)],
        ]);

        $this->assertCount(15, Models\Cart::all());

        $this->assertFalse(Models\Cart::all()->every(function(Models\Cart $cart) {
            return now()->diffInDays($cart->updated_at) < 30;
        }));

        Models\Cart::clean();

        $this->assertCount(7, Models\Cart::all());

        $this->assertTrue(Models\Cart::all()->every(function(Models\Cart $cart) {
            return now()->diffInDays($cart->updated_at) < 30;
        }));
    }

    /**
     * @test
     */
    public function can_set_additional_data()
    {
        cart()->addProduct([
            "plu" => 5
        ]);

        cart()->setAdditionalData([
            "comment" => "lorem ipsum"
        ]);

        cart()->setAdditionalData([
            "key" => "value",
            "key2" => "value2"
        ]);

        $cart = cart()->getCart();

        $this->assertEquals("lorem ipsum", $cart->additional["comment"]);
        $this->assertEquals("value", $cart->additional["key"]);
        $this->assertEquals("value2", $cart->additional["key2"]);

        cart()->setAdditionalData([
            "comment" => "Peanut Allergy",
        ]);

        $this->assertEquals("Peanut Allergy", cart()->getCart()->additional["comment"]);
    }

    /**
     * @test
     */
    public function can_update_identifier(){
        $customerId = 10;
        $identifier = md5($customerId);
        cart()->addProduct([
            "plu" => 5
        ]);

        cart()->updateIdentifier($identifier);

        $this->assertEquals($identifier, cart()->identifier);
        $this->assertEquals($identifier, session("cart_identifier"));
    }

    /**
     * @test
     */
    public function can_add_coupon_to_cart(){
        $coupon = cart()->couponsRepository->addCoupon([
            "name" => "WELCOME10",
            "discount_percent" => 0.10,
        ]);

        $product = cart()->addProduct([
            "plu" => 5,
            "price" => 4.99,
            "quantity" => 1
        ]);

        $product2 = cart()->addProduct([
            "plu" => 6,
            "price" => 4.99,
            "quantity" => 1
        ]);

        cart()->itemsRepository->setCouponCode($product, $coupon->name);
        cart()->itemsRepository->setCouponCode($product2, $coupon->name);

        $this->assertEquals($coupon->name, $product->coupon_code);
        $this->assertEquals($coupon->name, $product2->coupon_code);
    }

    /**
     * @test
     */
    public function can_set_shipping_method(){
        cart()->addProduct([
            "plu" => 5
        ]);

        $this->assertNull(cart()->getCart()->shipping_method);

        cart()->setShippingMethod("truck");

        $this->assertEquals("truck", cart()->getCart()->shipping_method);
    }

    /**
     * @test
     */
    public function get_total_price(){
        $this->assertEquals(0, cart()->getCart()->grand_total);

        cart()->addProduct([
            "plu" => 5,
            "price" => 4.99,
            "quantity" => 3,
            "tax_percent" => 0.06
        ]);

        $this->assertEquals(14.97, round(cart()->getCart()->grand_total, 2));
        $this->assertEquals(14.12, round(cart()->getCart()->sub_total, 2));
        $this->assertEquals(0.85, round(cart()->getCart()->tax_total, 2));
    }
    /**
     * @test
     */
    public function can_get_best_shipping_rate_for_cart(){
        $truck = cart()->shippingRateRepository->addShippingRate([
            "method" => "truck",
            "price" => 20,
            "minimum_cart_price" => 0
        ]);
        $truck2 = cart()->shippingRateRepository->addShippingRate([
            "method" => "truck",
            "price" => 10,
            "minimum_cart_price" => 50
        ]);
        $truck3 = cart()->shippingRateRepository->addShippingRate([
            "method" => "truck",
            "price" => 0,
            "minimum_cart_price" => 100
        ]);

        cart()->shippingRateRepository->addShippingRate([
            "method" => "plane",
            "price" => 25,
            "minimum_cart_price" => 110
        ]);

        cart()->setShippingMethod("truck");

        $this->assertCount(3, cart()->shippingRateRepository->shippingRatesForMethod("truck"));

        cart()->addProduct([
            "plu" => 5,
            "price" => 5,
            "quantity" => 1
        ]);

        $this->assertEquals($truck->price, cart()->getShippingRate()->price);

        cart()->addProduct([
            "plu" => 2,
            "price" => 45,
            "quantity" => 1
        ]);

        $this->assertEquals($truck2->price, cart()->getShippingRate()->price);

        cart()->addProduct([
            "plu" => 3,
            "price" => 15,
            "quantity" => 1
        ]);

        $this->assertEquals($truck2->price, cart()->getShippingRate()->price);

        cart()->addProduct([
            "plu" => 1,
            "price" => 34,
            "quantity" => 1
        ]);

        $this->assertEquals($truck2->price, cart()->getShippingRate()->price);

        cart()->addProduct([
            "plu" => 6,
            "price" => 2,
            "quantity" => 1
        ]);

        $this->assertEquals($truck3->price, cart()->getShippingRate()->price);

        cart()->addProduct([
            "plu" => 6,
            "price" => 40,
            "quantity" => 1
        ]);

        $this->assertEquals($truck3->price, cart()->getShippingRate()->price);
    }

    /**
     * @test
     */
    public function can_add_coupon_and_is_coupon_applied_correctly(){
        $frappucino = [
            "plu" => 5,
            "price" => 49.99,
            "quantity" => 1
        ];

        $machiato = [
            "plu" => 7,
            "price" => 12.99,
            "quantity" => 1
        ];

        $espresso = [
            "plu" => 3,
            "price" => 4.95,
            "quantity" => 1
        ];

        $cookie = [
            "plu" => 9,
            "price" => 0.95,
            "quantity" => 1
        ];

        // The Mocha Cookie Crumble Frappcino Starbucks didn't give me.
        cart()->addProduct($frappucino);

        $this->assertEquals(49.99, cart()->getCart()->grand_total);

        $welcome125 = cart()->couponsRepository->addCoupon([
            "name" => "WELCOME125",
            "coupon_type" => CouponTypes::PERCENT,
            "discount_percent" => 0.125
        ]);

        $freeCookies = cart()->couponsRepository->addCoupon([
            "name" => "FREECOOKIE",
            "coupon_type" => CouponTypes::AMOUNT,
            "discount_amount" => 0.95,
            "conditional" => true,
            "conditions" => collect([
                "cart_contains_plus" => [
                    [$frappucino["plu"]],
                    [$machiato["plu"], $espresso["plu"]]
                ]
            ])
        ]);

        cart()->addCoupon($welcome125);
        $this->assertCount(2, Models\CartCoupon::all());
        $this->assertEquals($welcome125->name, cart()->getCart()->coupon_code);

        $this->assertEquals(43.74, round(cart()->getCart()->grand_total, 2));

        cart()->destroy();

        cart()->addProduct($frappucino);

        $this->assertEquals($frappucino["price"], cart()->getCart()->grand_total);

        cart()->addProduct($cookie);

        $this->assertEquals($frappucino["price"] + $cookie["price"], cart()->getCart()->grand_total);

        cart()->addCoupon($freeCookies);

        $this->assertEquals($frappucino["price"], cart()->getCart()->grand_total);

        cart()->destroy();

        cart()->addProduct($machiato);

        $this->assertEquals($machiato["price"], cart()->getCart()->grand_total);

        cart()->addProduct($cookie);

        $this->assertEquals($machiato["price"] + $cookie["price"], cart()->getCart()->grand_total);

        cart()->addCoupon($freeCookies);

        $this->assertEquals($machiato["price"] + $cookie["price"], cart()->getCart()->grand_total);

        cart()->addProduct($espresso);

        $this->assertEquals($espresso["price"] + $machiato["price"], cart()->getCart()->grand_total);
    }

    /**
     * @test
     */
    public function can_add_coupon_to_cart_item_and_is_coupon_calculated_correctly(){
        $cookie = [
            "plu" => 9,
            "price" => 0.95,
            "quantity" => 1
        ];

        $buyTwoGetOneFree = cart()->couponsRepository->addCoupon([
            "name" => "342",
            "coupon_type" => CouponTypes::STEP,
            "discount_quantity" => 1,
            "discount_step" => 2,
            "conditional" => true,
            "conditions" => [
                "applies_to" => [$cookie["plu"]]
            ]
        ]);

        cart()->addProduct($cookie);

        $this->assertEquals(0.95, cart()->getCart()->grand_total);

        cart()->destroy();

        cart()->addProduct(
            collect($cookie)
                ->put('quantity', 2)
                ->toArray()
        );


        $this->assertEquals(0, cart()->getCart()->discount);
        $this->assertEquals(1.90, cart()->getCart()->grand_total);


        cart()->destroy();

        $item = cart()->addProduct(
            collect($cookie)
                ->put('quantity', 3)
                ->toArray()
        );

        $this->assertEquals(2.85, cart()->getCart()->grand_total);

        cart()->itemsRepository->setCouponCode($item, $buyTwoGetOneFree->name);

        $this->assertEquals(0.95, cart()->getCart()->discount);
        $this->assertEquals(1.90, cart()->getCart()->grand_total);
    }
}
