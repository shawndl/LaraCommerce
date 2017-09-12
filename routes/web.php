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

//Order Page
Route::get('/order/{stage}', 'User\OrderController@index');
Route::post('/order', 'User\API\OrderController@store');
Route::patch('/order/{order}', 'User\API\OrderController@update');
Route::post('/order/billing-form', 'User\API\BillingController@store');
Route::resource('user/address', 'User\API\AddressController');


//Order API
Route::get('/order/invoice/{order}', 'User\API\OrderController@show');

//Tests

Route::get('/test', function(){

    $a = new \App\Library\API\ApiResponseTracker();
    $b = new \App\Library\API\ErrorTracker\OrderErrorTracker($a);
    $c = \App\Address::first();
    $d = \App\User::find(51);
    //$d = \App\Order::find(51);
    $b->address = $c;
    $b->user = $d;
    $z = $b->create(new \App\Order());
    dd($b);

    /*
     * X Finish the order accuunt page by adding costs
     * X Add search function
     * X Move API search routes to User/API folder
     * 4) write tests
     * X Side bar needs to collapse when screen is small
     * X Fix navbar cart screen so it does not close for no reason
     * X When address is picked two orders are triggered
     * X Update nav bar and add an about page and contact page
     * 9) Write a review
     */
});


Route::post('/test', function(\Illuminate\Http\Request $request){
    dd($request);
})->middleware('ajax.auth');;

