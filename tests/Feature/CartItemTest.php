<?php


use Illuminate\Foundation\Testing\RefreshDatabase;
use juniorE\ShoppingCart\Models\CartItem;
use juniorE\ShoppingCart\Tests\TestCase;

class CartItemTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_set_parent_product(){
        $parent = cart()->addProduct([
            "plu" => 5
        ]);

        $sub1 = cart()->addProduct([
            "plu" => 6
        ]);

        $sub2 = cart()->addProduct([
            "plu" => 7
        ]);

        cart()->itemsRepository->setParentCartItem($sub1, $parent->id);
        cart()->itemsRepository->setParentCartItem($sub2, $parent->id);

        $this->assertEquals($parent->id, $sub1->parent->id);
        $this->assertEquals($parent->id, $sub2->parent->id);

        $this->assertCount(2, $parent->subproducts);
        $this->assertEquals($sub1->id, $parent->subproducts->first()->id);
        $this->assertEquals($sub2->id, $parent->subproducts->last()->id);
    }

    /**
     * @test
     */
    public function can_set_additional_data(){
        $product = cart()->addProduct([
            "plu" => 5
        ]);

        cart()->itemsRepository->setAdditionalData($product, [
            "unit" => "kilogram",

        ]);

        cart()->itemsRepository->setAdditionalData($product, [
            "key" => "value"
        ]);

        $product = CartItem::firstWhere('id', $product->id);
        $this->assertEquals("kilogram", $product->additional["unit"]);
        $this->assertEquals("value", $product->additional["key"]);

        cart()->itemsRepository->setAdditionalData($product, [
            "unit" => "person",

        ]);

        $product = CartItem::firstWhere('id', $product->id);
        $this->assertEquals("person", $product->additional["unit"]);
    }

    /**
     * @test
     */
    public function can_set_price(){
        $product = cart()->addProduct([
            "plu" => 5,
            "price" => 10
        ]);

        $this->assertEquals(10, $product->price);

        cart()->itemsRepository->setPrice($product, 15);

        $product = CartItem::firstWhere('id', $product->id);
        $this->assertEquals(15, $product->price);
    }
    
    /**
     * @test
     */
    public function can_update_weight(){
        $product = cart()->addProduct([
            "plu" => 5,
            "weight" => 10
        ]);

        $this->assertEquals(10, $product->weight);

        cart()->itemsRepository->setWeight($product, 15);

        $product = CartItem::firstWhere('id', $product->id);
        $this->assertEquals(15, $product->weight);
    }

    /**
     * @test
     */
    public function can_update_tax_percent(){
        $product = cart()->addProduct([
            "plu" => 5,
            "tax_percent" => 0.21
        ]);

        $this->assertEquals(0.21, $product->tax_percent);

        cart()->itemsRepository->setTaxPercent($product, 0.06);

        $product = CartItem::firstWhere('id', $product->id);
        $this->assertEquals(0.06, $product->tax_percent);
    }
}
