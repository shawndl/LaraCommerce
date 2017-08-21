<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SideBarServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('_includes._ecommerce._sidebar', function($view){
            $categories = \App\Category::all();
            $view->with('categories', $categories);
        });

        View::composer('_includes._ecommerce._navbar', function($view){
            $categories = \App\Category::pluck('name');
            $view->with('categories', $categories);
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
}
