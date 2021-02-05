<?php


namespace juniorE\ShoppingCart\Models;


use Illuminate\Database\Eloquent\Model;

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
}
