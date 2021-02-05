<?php


namespace juniorE\ShoppingCart;


use Carbon\Laravel\ServiceProvider;

class ShoppingCartBaseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishResources();
        $this->registerResources();
    }

    public function register()
    {
        app()->singleton(BaseCart::class, Cart::class);
        $this->mergeConfigFrom(
            __DIR__.'/../config/shoppingcart.php', 'shoppingcart'
        );
    }

    private function registerResources()
    {
        $this->loadMigrationsFrom(__DIR__."/../database/migrations");
    }

    private function publishResources()
    {
        $this->publishes([
            __DIR__.'/../config/shoppingcart.php' => config_path('shoppingcart'),
        ]);
    }
}
