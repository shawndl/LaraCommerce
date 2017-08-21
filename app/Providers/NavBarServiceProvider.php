<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Syscover\ShoppingCart\Facades\CartProvider;

class NavBarServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('_includes._ecommerce._navbar', function($view){
            $numberOfItems = $this->formatNumberOfItems(CartProvider::instance()->getCartItems()->count());
            $total = '$' . CartProvider::instance()->getTotal();
            $view->with([
                'numberOfItems' => $numberOfItems,
                'total' => $total
            ]);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * receives the number of items in shopping cart and returns the correct message
     *
     * @param $number
     * @return string
     */
    protected function formatNumberOfItems($number)
    {
        if($number === 0)
        {
            return 'Empty Cart';
        }
        if($number === 1)
        {
            return '(1) item';
        }
        return "($number) items";
    }
}
