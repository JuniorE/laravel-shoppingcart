<?php


namespace juniorE\ShoppingCart\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * Class Cart
 * @package juniorE\ShoppingCart\Models
 *
 * @property int $id
 * @property string $identifier
 * @property string|null $shipping_method
 * @property string|null $coupon_code
 * @property int|null $items_count
 * @property double|null $grand_total
 * @property double|null $sub_total
 * @property double|null $tax_total
 * @property double|null $discount
 * @property string|null $checkout_method
 * @property int|null $conversion_time
 * @property Object|null $additional
 * @property Carbon $updated_at
 * @property Carbon $created_at
 *
 * @method static Builder|static where(string $column, string $operator, mixed $value, $boolean="and")
 * @method static Builder|static query()
 * @method static Model|Collection|static[]|static|null find(mixed $id, array $columns=[])
 */
class Cart extends Model
{
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function getCouponsAttribute()
    {
        return collect();
    }

    public static function clean(): void
    {
        try {
            Cart::where("updated_at", "<=", now()->subDays(config("shoppingcart.database.ttl")))
                ->delete();
        } catch (\Exception $e) {
            Log::error("Error while trying to clean up database.");
        }
    }
}
