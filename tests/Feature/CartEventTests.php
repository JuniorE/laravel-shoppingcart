<?php


use Illuminate\Foundation\Testing\RefreshDatabase;
use juniorE\ShoppingCart\Events\CartItems\CartItemCreatedEvent;
use juniorE\ShoppingCart\Events\CartItems\CartItemDeletedEvent;
use juniorE\ShoppingCart\Events\CartItems\CartItemUpdatedEvent;
use juniorE\ShoppingCart\Tests\TestCase;

class CartEventTests extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function cart_item_updated_event(){
        Event::fake([
            CartItemCreatedEvent::class,
            CartItemUpdatedEvent::class,
            CartItemDeletedEvent::class
        ]);

        $item = cart()->addProduct([
            "plu" => 5
        ]);

        Event::assertDispatchedTimes(CartItemCreatedEvent::class, 1);

        cart()->itemsRepository->setQuantity($item, 1);

        Event::assertDispatchedTimes(CartItemUpdatedEvent::class, 1);

        cart()->removeItem($item);

        Event::assertDispatchedTimes(CartItemDeletedEvent::class, 1);
    }
}
