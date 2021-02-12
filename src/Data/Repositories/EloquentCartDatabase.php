<?php


namespace juniorE\ShoppingCart\Data\Repositories;


use Illuminate\Support\Collection;
use juniorE\ShoppingCart\Data\Interfaces\CartDatabase;
use juniorE\ShoppingCart\Models\Cart;
use juniorE\ShoppingCart\Models\CartCoupon;
use juniorE\ShoppingCart\Models\CartItem;

class EloquentCartDatabase implements CartDatabase
{
    public function createCart(string $identifier): Cart
    {
        return Cart::create([
            "identifier" => $identifier
        ]);
    }

    /**
     * @param string $identifier
     * @return Cart|null
     */
    public function getCart(string $identifier)
    {
        return Cart::where('identifier', "=", $identifier)->first();
    }

    public function createCartItem(array $product): CartItem
    {
        $cartItem = CartItem::create(
            collect($product)
                ->merge([
                    "tax_amount" => ($product["price"] ?? 0) * ($product["tax_percent"] ?? 0)
                ])
                ->toArray()
        );
        $this->updateTotal();
        return $cartItem;
    }

    /**
     * @param int $id
     * @return CartItem|null
     */
    public function getCartItem(int $id)
    {
        return CartItem::find($id);
    }

    /**
     * @param string $hash
     * @return CartItem|null
     */
    public function getCartItemByHash(string $hash)
    {
        return CartItem::firstWhere('row_hash', $hash);
    }

    /**
     * @param int|null $cartIdentifier
     * @return Collection|CartItem[]
     */
    public function getCartItems(int $cartIdentifier=null)
    {
        return CartItem::where('cart_id', $cartIdentifier ?: cart()->id)->get();
    }

    public function getCartItemsTree(int $cartIdentifier=null): Collection
    {
        return CartItem::where('cart_id', $cartIdentifier ?: cart()->id)
            ->whereNull('parent_id')
            ->with('subproducts')
            ->get();
    }

    public function removeCartItem(CartItem $item): void
    {
        $item->delete();
    }

    public function setCheckoutMethod(string $method): void
    {
        cart()->getCart()->update([
            "checkout_method" => $method
        ]);
    }

    public function setShippingMethod(string $method): void
    {
        cart()->getCart()->update([
            "shipping_method" => $method
        ]);
    }

    public function setConversionTime(int $minutes): void
    {
        cart()->getCart()->update([
            "conversion_time" => $minutes
        ]);
    }

    public function addCoupon(CartCoupon $coupon): void {
        cart()->getCart()->update([
            "coupon_code" => $coupon->name
        ]);

        $this->updateTotal();
    }

    public function clear(bool $hard=false): void
    {
        if ($hard) {
            cart()->getCart()->forceDelete();
        } else {
            cart()->getCart()->delete();
        }
    }

    public function setAdditionalData(array $data)
    {
        $cart = cart()->getCart();
        $cart->update([
            'additional' => collect($cart->additional)
                ->merge($data)
        ]);
    }

    public function updateTotal()
    {
        $cart = cart()->getCart();
        $total = cart()->items()->reduce(function($carry, CartItem $item) {
            return $carry + $item->price * $item->quantity;
        });

        $subtotal = cart()->items()->reduce(function($carry, CartItem $item) {
            return $carry + ($item->price * $item->quantity) / (1 + $item->tax_percent);
        });

        $taxes = $total - $subtotal;

        $discount = $this->totalDiscount($total);

        $cart->update([
            "grand_total" => $total - $discount,
            "tax_total" => $taxes,
            "sub_total" => $subtotal,
            "discount" => $discount
        ]);
    }

    private function totalDiscount(float $total)
    {
        $coupon = cart()->getCart()->coupon;

        $itemDiscounts = cart()->items()->reduce(function($carry, $item) {
            return $carry + $item->discount;
        }, 0);

        if ($coupon) {
            return $coupon->discount($total) + $itemDiscounts;
        }
        return 0 + $itemDiscounts;
    }
}
