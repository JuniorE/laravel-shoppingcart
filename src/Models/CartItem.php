<?php


namespace juniorE\ShoppingCart\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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

    public function updateHash()
    {
        $this->row_hash = $this->getRowHash();
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

        static::creating(function(CartItem $model) {
            $model->updateHash();
        });

        static::saving(function(CartItem $model) {
            $model->updateHash();
        });

        static::updating(function(CartItem $model) {
            $model->updateHash();
        });
    }
}
