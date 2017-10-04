<?php
/*
|--------------------------------------------------------------------------
| AdminUrlData.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for returning a list of common urls that will be
| used by vue in the admin site
*/

namespace App\Library\Data;


class AdminUrlData
{
    public static function get()
    {
        return [
            'product_url' => action('Admin\ProductsController@index'),
            'product_api_url' => action('Admin\API\ProductsAPIController@index'),
            'tax_url' => action('Admin\TaxesController@index'),
            'tax_api_url' => action('Admin\API\TaxesAPIController@index'),
            'sale_url' => action('Admin\SalesController@index'),
            'order_url' => action('Admin\API\OrdersAPIController@show', ['order' => null]),
            'category_url' => action('Admin\CategoriesController@index'),
            'category_api_url' => action('Admin\API\CategoriesAPIController@index')
        ];
    }
}