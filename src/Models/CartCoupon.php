<?php


namespace juniorE\ShoppingCart\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CartCoupon
 * @package juniorE\ShoppingCart\Models
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property bool $status
 * @property int $coupon_type
 * @property Carbon|null $starts_from
 * @property Carbon|null $ends_till
 * @property int $usage_per_customer
 * @property int $uses_per_coupon
 * @property int $times_used
 * @property boolean $conditional
 * @property array $conditions
 * @property bool|null $ends_other_coupons
 * @property double|null $discount_amount
 * @property double|null $discount_percent
 * @property int|null $discount_quantity
 * @property int|null $discount_step
 * @property bool $apply_to_shipping
 * @property bool $free_shipping
 * @property Carbon $updated_at
 * @property Carbon $created_at
 */
class CartCoupon extends Model
{
    protected $guarded = [];

    protected $casts = [
        "additional" => "array",
        "starts_from" => "datetime",
        "ends_till" => "datetime",
        "updated_at" => "datetime",
        "created_at" => "datetime",

    ];
}
