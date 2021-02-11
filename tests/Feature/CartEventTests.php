<?php


use Illuminate\Foundation\Testing\RefreshDatabase;
use juniorE\ShoppingCart\Events\Cart\CartCreatedEvent;
use juniorE\ShoppingCart\Events\Cart\CartDeletedEvent;
use juniorE\ShoppingCart\Events\Cart\CartUpdatedEvent;
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
    public function cart_events(){
        Event::fake([
            CartCreatedEvent::class,
            CartUpdatedEvent::class,
            CartDeletedEvent::class
        ]);

        $cart = cart();

        Event::assertDispatchedTimes(CartCreatedEvent::class, 1);

        cart()->updateIdentifier(md5(now()->toISOString()));

        Event::assertDispatchedTimes(CartUpdatedEvent::class, 1);

        cart()->destroy();

        Event::assertDispatchedTimes(CartDeletedEvent::class, 1);
    }

    /**
     * @test
     */
    public function cart_item_events(){
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
