<?php


namespace juniorE\ShoppingCart\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CartShippingRate
 * @package juniorE\ShoppingCart\Models
 *
 * @property int $id
 * @property int $cart_id
 * @property array $history
 * @property Carbon $updated_at
 * @property Carbon $created_at
 */
class VisitsHistory extends Model
{
    protected $guarded = [];

    protected $casts = [
        "history" => "array",
        "updated_at" => "datetime",
        "created_at" => "datetime",

    ];
}
