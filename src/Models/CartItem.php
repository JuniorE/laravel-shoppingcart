<?php


namespace juniorE\ShoppingCart\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use juniorE\ShoppingCart\Events\CartItems\CartItemCreatedEvent;
use juniorE\ShoppingCart\Events\CartItems\CartItemDeletedEvent;
use juniorE\ShoppingCart\Events\CartItems\CartItemUpdatedEvent;

/**
 * Class CartItem
 * @package juniorE\ShoppingCart\Models
 *
 * @property int $id
 * @property int $cart_id
 * @property int|null $parent_id
 * @property string row_hash
 * @property int $quantity
 * @property string $plu
 * @property int $type
 * @property double $weight
 * @property double $total_weight
 * @property string|null $coupon_code
 * @property double $price
 * @property double $total
 * @property double|null $tax_percent
 * @property double|null $tax_amount
 * @property array|null $additional
 * @property Carbon $updated_at
 * @property Carbon $created_at
 */
class CartItem extends Model
{
    protected $guarded = [];

    protected $casts = [
        "price" => "float",
        "cart_id" => "int",
        "plu" => "int",
        "additional" => "array",
        "updated_at" => "datetime",
        "created_at" => "datetime",

    ];

    public function subproducts()
    {
        return $this->hasMany(CartItem::class, "parent_id");
    }

    public function parent()
    {
        return $this->belongsTo(CartItem::class, "parent_id");
    }

    public function coupon()
    {
        return $this->hasOne(CartCoupon::class, 'name', 'coupon_code');
    }

    public function onUpdate()
    {
        $this->updateHash();
        $this->updateTotals();
    }

    public function updateHash()
    {
        $this->row_hash = $this->getRowHash();
    }

    public function updateTotals()
    {
        $this->total = ($this->price ?? 0) * ($this->quantity ?? 0);
        $this->tax_amount = $this->total - ($this->total / (1 + ($this->tax_percent ?? 0)));
    }

    public static function getHash($attributes)
    {
        return (new static($attributes))->getRowHash();
    }

    public function getRowHash()
    {
        return sha1(
            collect($this->attributes)
                ->only([
                    'additional'
                ])
                ->put('cart_id', (int) $this->cart_id)
                ->put('plu', (int) $this->plu)
                ->toJson()
        );
    }

    protected static function boot()
    {
        parent::boot();

        static::updated(function(CartItem $model) {
            event(new CartItemUpdatedEvent($model));
        });

        static::created(function(CartItem $model) {
            event(new CartItemCreatedEvent($model));
        });

        static::deleted(function(CartItem $model) {
            event(new CartItemDeletedEvent($model));
        });

        static::creating(function(CartItem $model) {
            $model->onUpdate();
        });

        static::saving(function(CartItem $model) {
            $model->onUpdate();
        });

        static::updating(function(CartItem $model) {
            $model->onUpdate();
        });
    }
}
