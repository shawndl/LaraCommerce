<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('alpha_spaces', function($attribute, $value)
        {
            return preg_match('/^[\pL\s]+$/u', $value);
        });

        Validator::extend('alpha_numeric_spaces', function($attribute, $value)
        {
            return preg_match('/^[\pL1-90\s]+$/u', $value);
        });

        Validator::extend('basic_characters', function($attribute, $value)
        {
            return preg_match('/^[\pL1-90\s.\',?!]+$/u', $value);
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
