<?php


namespace juniorE\ShoppingCart;


use Hash;
use Illuminate\Support\Collection;
use juniorE\ShoppingCart\Data\Interfaces\CartDatabase;
use juniorE\ShoppingCart\Models\CartCoupon;
use juniorE\ShoppingCart\Models\CartItem;

abstract class BaseCart implements Contracts\Cart
{
    protected const SESSION_CART_IDENTIFIER="cart_identifier";

    /**
     * @var CartItemsRepository
     */
    public $itemsRepository;

    /**
     * @var CartCouponRepository
     */
    public $couponsRepository;

    /**
     * @var string
     */
    public $identifier;

    /**
     * @var int
     */
    public $id;

    /**
     * @var Collection|CartItem[]
     */
    protected $cartItems;

    /**
     * @var Collection|CartCoupon[]
     */
    protected $coupons;


    /**
     * BaseCart constructor.
     * @param string|null $identifier
     */
    public function __construct(string $identifier=null)
    {
        if (!$identifier) {
            $this->restoreOrCreateIdentifier();
        }

        $this->itemsRepository = new CartItemsRepository();
        $this->couponsRepository = new CartCouponRepository();

        session()->put(self::SESSION_CART_IDENTIFIER, $this->identifier);
    }

    public function destroy(): void
    {
        app(CartDatabase::class)->clear();
        $this->create();
    }

    /**
     * Restore or Create the cart using the Session Identifier
     * @return string
     */
    public function restoreOrCreateIdentifier()
    {
        if (session(self::SESSION_CART_IDENTIFIER)) {
            return $this->restore(session(self::SESSION_CART_IDENTIFIER));
        }

        return $this->create();
    }

    /**
     * Restore cart by identifier
     *
     * @param string $identifier
     * @return string
     */
    private function restore(string $identifier): string
    {
        $this->identifier = $identifier;

        $cart = app(CartDatabase::class)->getCart($this->identifier);
        if (!$cart) {
            return $this->create();
        }

        $this->id = $cart->id;
        $this->cartItems = $cart->items;
        $this->coupons = $cart->coupons;

        return $this->identifier;
    }

    /**
     * Create Cart
     *
     * @return string
     */
    private function create(): string
    {
        $this->identifier = self::generateIdentifier();

        $cart = app(CartDatabase::class)->createCart($this->identifier);

        $this->id = $cart->id;
        $this->cartItems = collect();
        $this->coupons = collect();

        session()->put(self::SESSION_CART_IDENTIFIER, $this->identifier);

        return $this->identifier;
    }

    public static function generateIdentifier(): string
    {
        return Hash::make(now()->toISOString());
    }
}
