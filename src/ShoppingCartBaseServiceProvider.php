<?php


namespace juniorE\ShoppingCart;


use Carbon\Laravel\ServiceProvider;

class ShoppingCartBaseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/shoppingcart.php' => config_path('shoppingcart'),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/shoppingcart.php', 'shoppingcart'
        );
    }
}
