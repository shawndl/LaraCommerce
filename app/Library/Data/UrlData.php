<?php
/*
|--------------------------------------------------------------------------
| UrlData.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for returning a list of common urls that will be
| used by vue
*/

namespace App\Library\Data;


class UrlData
{
    public static function get()
    {
        return [
            'state_url' => action('User\API\StateController@index'),
            'address_url' => action('User\API\AddressController@index'),
            'order_url' => action('User\API\OrderController@store'),
            'billing_url' => action('User\API\BillingController@store'),
            'users_url' => action('User\API\UserController@index'),
            'user_order_url' => action('User\UserAccountController@show', ['order_id' => null]),
            'search_url' => action('User\SearchController@show', ['search' => null]),
            'show_product_url' => action('User\ProductsController@show', ['product' => null]),
            'shopping_cart' => action('User\API\ShoppingCartController@index'),
            'shopping_cart_add' => action('User\API\ShoppingCartController@store'),
            'shopping_cart_delete' => action('User\API\ShoppingCartController@destroy'),
            'shopping_cart_update' => action('User\API\ShoppingCartController@update'),
            'category_url' => action('User\SearchController@category', ['category' => null]),
            'user_email_url' => action('Auth\RegisterValidationController@email'),
            'user_username_url' => action('Auth\RegisterValidationController@username')
        ];
    }
}

