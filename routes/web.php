<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Auth routes
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Auth::routes();

//Register User
Route::post('user-email-taken', 'Auth\RegisterValidationController@email');
Route::post('user-username-taken', 'Auth\RegisterValidationController@username');
Route::get('get-states', 'User\API\StateController@index');

// Home Routes
Route::get('/', 'HomeController@index');
Route::get('about', 'HomeController@about');
Route::get('contact', 'HomeController@contact');
Route::get('view-product/{title}', 'User\ProductsController@show');

// Search
Route::get('product/{category}', 'User\SearchController@category');
Route::post('products', 'User\SearchController@scout');
Route::get('products/{search}', 'User\SearchController@show');
Route::post('products/api', 'User\API\SearchController@store');

// Shopping Cart Routes
Route::post('shopping-cart/add', 'User\API\ShoppingCartController@store');
Route::post('shopping-cart/remove', 'User\API\ShoppingCartController@destroy');
Route::post('shopping-cart/update', 'User\API\ShoppingCartController@update');
Route::get('shopping-cart/get', 'User\API\ShoppingCartController@index');

//User Account
Route::get('user/user-account', 'User\UserAccountController@index');
Route::get('user/user-account/order/{id}', 'User\UserAccountController@show');
Route::get('user/users-details', 'User\API\UserController@index');

//orders Page
Route::get('/order/{stage}', 'User\OrderController@index');
Route::post('/order', 'User\API\OrderController@store');
Route::patch('/order/{order}', 'User\API\OrderController@update');
Route::post('/order/billing-form', 'User\API\BillingController@store');
Route::resource('user/address', 'User\API\AddressController');

//orders API
Route::get('/order/invoice/{order}', 'User\API\OrderController@show');

/*
|--------------------------------------------------------------------------
| Admin Section
|--------------------------------------------------------------------------
| The following routes are from the admin section of Lara-Commerce.  In order
| to access these pages the user must have admin privileges.
*/
Route::get('admin', 'Admin\AdminHomeController@index');

//Products
Route::resource('admin/products', 'Admin\ProductsController');
Route::post('admin/products/image/{product}', 'Admin\API\ProductsAPIController@image');
Route::get('admin/products-api/', 'Admin\API\ProductsAPIController@index');


// Sales
Route::resource('admin/products/sales', 'Admin\SalesController');

// Users
Route::get('admin/users', 'Admin\UsersController@index');
Route::get('admin/users/addresses/{user}', 'Admin\UsersController@addresses');
Route::get('admin/users/orders/{user}', 'Admin\UsersController@orders');

// Orders
Route::get('admin/orders', 'Admin\OrdersController@index');
Route::get('admin/orders/{id}', 'Admin\OrdersController@show');
Route::get('admin/orders/view/{order}', 'Admin\API\OrdersAPIController@show');
Route::post('admin/orders/view/{order}', 'Admin\API\OrdersAPIController@store');

// Categories
Route::get('admin/categories', 'Admin\CategoriesController@index');
Route::resource('admin/api/categories', 'Admin\API\CategoriesAPIController');

//Taxes
Route::get('admin/taxes', 'Admin\TaxesController@index');
Route::get('admin/api/taxes/all', 'Admin\API\TaxesAPIController@all');
Route::resource('admin/api/taxes', 'Admin\API\TaxesAPIController');



Route::get('/test', function(){
    dd(\Illuminate\Support\Facades\Schema::hasTable('roles'));

    return view('test');
});


Route::post('/test', function(\Illuminate\Http\Request $request){


})->middleware('ajax.auth');;

