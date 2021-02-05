<?php


namespace juniorE\ShoppingCart\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CartShippingRate
 * @package juniorE\ShoppingCart\Models
 *
 * @property int $id
 * @property string $method
 * @property string|null $method_description
 * @property double $price
 * @property double $minimum_cart_price
 * @property Carbon $updated_at
 * @property Carbon $created_at
 */
class CartShippingRate extends Model
{
    protected $guarded = [];

    protected $casts = [
        "additional" => "array",
        "updated_at" => "datetime",
        "created_at" => "datetime",

    ];
}
